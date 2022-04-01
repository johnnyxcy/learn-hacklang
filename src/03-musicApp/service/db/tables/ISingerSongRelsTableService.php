<?hh

namespace LearnHH\MusicApp\Service\DB\Tables {
    type IRel = shape('song_uid' => string, 'singer_uid' => string);

    interface ISingerSongRelsTableService {
        public function isReadyAsync(): Awaitable<bool>;
        public function getSingerUIDAsync(
            string $song_uid,
        ): Awaitable<vec<string>>;
        public function getSongUIDAsync(
            string $singer_uid,
        ): Awaitable<vec<string>>;
        public function setRelAsync(IRel $rel): Awaitable<void>;
        public function removeRelAsync(IRel $rel): Awaitable<void>;
    }
}
