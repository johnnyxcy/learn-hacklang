<?hh

namespace LearnHH\MusicApp\Service {
    use namespace LearnHH\MusicApp\Model;

    interface IMusicMainSerivce {
        public function awaitReadyAsync(): Awaitable<void>;
        public function getAllSongsAsync(
            string $singer_uid,
        ): Awaitable<vec<Model\ISong>>;

        public function getAllSingersAsync(
            string $song_uid,
        ): Awaitable<vec<Model\ISinger>>;

        public function addRelsAsync(
            Model\Singer $singer,
            Model\ISong $song,
        ): Awaitable<void>;
    }
}
