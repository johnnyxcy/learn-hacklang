<?hh

namespace LearnHH\MusicApp\Service\DB {

    interface IConnectionManager {
        public function connectAsync(string $dbname): Awaitable<void>;
        public function disconnect(string $dbname): void;
        public function isConnected(string $dbname): bool;
        public function get(string $dbname): \AsyncMysqlConnection;
    }
}