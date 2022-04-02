<?hh

namespace LearnHH\MusicApp\Service {
    use namespace LearnHH\MusicApp\Service\DB;
    use namespace LearnHH\MusicApp\Model;

    class MusicMainSerivceImpl implements IMusicMainSerivce {
        private Awaitable<bool> $is_ready;
        public function __construct(private DB\IMusicDBService $music_db) {
            $this->is_ready = $this->music_db->isReadyAsync();
        }

        public async function awaitReadyAsync(): Awaitable<void> {
            await $this->is_ready;
        }

        public async function getAllSongsAsync(
            string $singer_uid,
        ): Awaitable<vec<Model\ISong>> {
            $songs = vec[];
            $songs_uid_vec = await $this->music_db
                ->rels()
                ->getSongUIDAsync($singer_uid);

            // You cannot do this because sql can only query once a time
            // Vec\from_async()

            foreach ($songs_uid_vec as $_ => $song_uid) {
                // FIXME: use sql->multiQuery instead of await here
                $songs[] = await $this->music_db->songs()->getAsync($song_uid);
            }

            return $songs;
        }

        public async function getAllSingersAsync(
            string $song_uid,
        ): Awaitable<vec<Model\ISinger>> {
            $singers = vec[];
            $singers_uid_vec = await $this->music_db
                ->rels()
                ->getSingerUIDAsync($song_uid);

            foreach ($singers_uid_vec as $_ => $singer_uid) {
                $singers[] = await $this->music_db
                    ->singers()
                    ->getAsync($singer_uid);
            }

            return $singers;
        }

        public async function addRelsAsync(
            Model\Singer $singer,
            Model\ISong $song,
        ): Awaitable<void> {
            await $this->music_db->rels()->setRelAsync(shape(
                'singer_uid' => $singer->getUID(),
                'song_uid' => $song->getUID(),
            ));
        }
    }
}
