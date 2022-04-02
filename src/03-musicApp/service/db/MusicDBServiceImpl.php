<?hh

namespace LearnHH\MusicApp\Service\DB {
    use type LearnHH\MusicApp\Service\DB\Tables\{
        ISingerSongRelsTableService,
        ISingersTableService,
        ISongsTableService,
        SingerSongRelsTableImpl,
        SingersTableServiceImpl,
        SongsTableServiceImpl,
    };

    class MusicDBServiceImpl implements IMusicDBService {
        private Awaitable<bool> $is_ready;
        private ?ISongsTableService $_songs;
        private ?ISingersTableService $_singer;
        private ?ISingerSongRelsTableService $_rels;

        public function __construct(private IConnectionManager $manager) {
            $this->is_ready = $this->initAsync();
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

            $this->_songs =
                new SongsTableServiceImpl($this->manager->get('music'));
            await $this->_songs->isReadyAsync();

            $this->_singer =
                new SingersTableServiceImpl($this->manager->get('music'));
            await $this->_singer->isReadyAsync();

            $this->_rels =
                new SingerSongRelsTableImpl($this->manager->get('music'));
            await $this->_rels->isReadyAsync();

            // NOTE: Cannot do this asio beacuase connection can only query once a time
            // $all_ready = await \HH\Asio\v(vec[
            //     ($this->_songs as ISongsTableService)->isReadyAsync(),
            //     ($this->_singer as ISingersTableService)->isReadyAsync(),
            //     ($this->_rels as ISingerSongRelsTableService)->isReadyAsync(),
            // ]);

            // $partition_tuple =
            //     Vec\partition($all_ready, $is_ready ==> $is_ready);

            // if (C\count($partition_tuple[0]) !== C\count($all_ready)) {
            //     return false;
            // }

            return true;
        }

        public function isReadyAsync(): Awaitable<bool> {
            return $this->is_ready;
        }

        public function singers(): ISingersTableService {
            if ($this->_singer is null) {
                throw new \Exception();
            }

            return $this->_singer;
        }

        public function songs(): ISongsTableService {
            if ($this->_songs is null) {
                throw new \Exception();
            }

            return $this->_songs;
        }

        public function rels(): ISingerSongRelsTableService {
            if ($this->_rels is null) {
                throw new \Exception();
            }

            return $this->_rels;
        }
    }
}
