<?hh

namespace LearnHH\MusicApp\Service\DB {

    use namespace HH\Lib\C;

    class ConnectionManagerImpl implements IConnectionManager {
        private dict<string, \AsyncMysqlConnection> $connection_mapping;
        public function __construct(
            private int $port,
            private string $user,
            private string $password,
        ) {
            $this->connection_mapping = dict[];
        }

        public async function connectAsync(string $dbname): Awaitable<void> {
            $this->connection_mapping[$dbname] =
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
                $this->connection_mapping[$dbname]->close();
                unset($this->connection_mapping[$dbname]);
            }
        }

        public function isConnected(string $dbname): bool {
            return C\contains_key($this->connection_mapping, $dbname);
        }

        public function get(string $dbname): \AsyncMysqlConnection {
            return $this->connection_mapping[$dbname];
        }
    }
}
