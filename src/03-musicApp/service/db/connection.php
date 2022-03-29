<?hh

namespace LearnHH\MusicApp\Services\DB\Connection {

    use namespace HH\Lib\{C};

    interface IDBConnectionService extends \IDisposable {
        public function connectAsync(string $dbname): Awaitable<void>;
        public function disconnect(string $dbname): void;
        public function isConnected(string $dbname): bool;
        public function get(string $dbname): \AsyncMysqlConnection;
    }

    class DBConnectionService implements IDBConnectionService {
        private dict<string, \AsyncMysqlConnection> $connectionMapping;
        public function __construct(
            private int $port,
            private string $user,
            private string $password,
        ) {
            $this->connectionMapping = dict[];
        }

        public function __dispose(): void {
            foreach ($this->connectionMapping as $_ => $connection) {
                $connection->close();
            }
        }

        public async function connectAsync(string $dbname): Awaitable<void> {
            $this->connectionMapping[$dbname] =
                await \AsyncMysqlClient::connect(
                    '127.0.0.1',
                    $this->port,
                    $dbname,
                    $this->user,
                    $this->password,
                );
        }

        public function disconnect(string $dbname): void {
            if ($this->isConnected($dbname)) {
                $this->connectionMapping[$dbname]->close();
                unset($this->connectionMapping[$dbname]);
            }
        }

        public function isConnected(string $dbname): bool {
            return C\contains_key($this->connectionMapping, $dbname);
        }

        public function get(string $dbname): \AsyncMysqlConnection {
            return $this->connectionMapping[$dbname];
        }
    }

    trait SQLTrait {
        private \AsyncMysqlConnection $sql;
        public function __construct(\AsyncMysqlConnection $sqlConnection) {
            $this->sql = $sqlConnection;
        }
    }
}
