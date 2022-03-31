<?hh

namespace LearnHH\MusicApp\Service\DB {
    use type LearnHH\MusicApp\Service\DB\Tables\{
        ISongsTableService,
        SongsTableService,
    };

    interface IMusicDBService {
        public function isReadyAsync(): Awaitable<bool>;
        public function songsTableService(): ISongsTableService;
        // public function songsTableService(): Tables\ISongsTableService;
    }

    class MusicDBService implements IMusicDBService {
        private Awaitable<bool> $_isReady;
        private ?ISongsTableService $_songsTableService;

        public function __construct(private IConnectionManager $manager) {
            $this->_isReady = $this->initAsync();
        }

        private async function initAsync(): Awaitable<bool> {
            if (!$this->manager->isConnected('mysql')) {
                await $this->manager->connectAsync('mysql');
            }
            await (
                $this->manager
                    ->get('mysql')
                    ->query('CREATE DATABASE IF NOT EXISTS music')
            );

            await $this->manager->connectAsync('music');

            $this->_songsTableService =
                new SongsTableService($this->manager->get('music'));

            if (!await $this->_songsTableService->isReadyAsync()) {
                throw new \Exception('Songs Table Service is not Ready');
            }

            return true;
        }

        public function isReadyAsync(): Awaitable<bool> {
            return $this->_isReady;
        }

        public function songsTableService(): ISongsTableService {
            if ($this->_songsTableService is null) {
                throw new \Exception('Not Initialized yet');
            }
            return $this->_songsTableService;
        }
    }
}
