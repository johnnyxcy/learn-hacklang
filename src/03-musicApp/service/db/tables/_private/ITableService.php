<?hh

namespace LearnHH\MusicApp\Service\DB\Tables\_Private {
    interface ITableSerivce<T> {
        public function isReadyAsync(): Awaitable<bool>;
        public function getAllAsync(): Awaitable<vec<T>>;
        public function getAsync(string $uid): Awaitable<T>;
        // public function getMultiAsync(vec<string> $uid): Awaitable<T>;
        public function removeAsync(string $uid): Awaitable<bool>;
        public function updateAsync(T $data): Awaitable<bool>;
    }
}
