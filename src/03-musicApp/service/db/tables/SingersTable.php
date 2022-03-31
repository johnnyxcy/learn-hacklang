<?hh

namespace LearnHH\MusicApp\Service\DB\Tables {
    use namespace LearnHH\MusicApp\Model;

    interface ISingersTable {
        public function getAllSingersAsync(): Awaitable<vec<Model\ISinger>>;
        public function getSingerAsync(
            string $singer_uid,
        ): Awaitable<Model\ISinger>;
        public function removeSingerAsync(string $singer_uid): Awaitable<bool>;
        public function updateSingerAsync(
            string $singer_uid,
            Model\ISinger $singer,
        ): Awaitable<bool>;
    }
}
