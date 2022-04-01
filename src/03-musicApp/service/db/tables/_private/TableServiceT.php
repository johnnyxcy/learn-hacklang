<?hh

namespace LearnHH\MusicApp\Service\DB\Tables\_Private {

    trait TableSerivceT<T> {
        require implements ITableSerivce<T>;
        private \AsyncMysqlConnection $db;
        private Awaitable<bool> $_is_ready;
        public function __construct(\AsyncMysqlConnection $db) {
            $this->db = $db;
            $this->_is_ready = (
                async () ==> {
                    await $this->initTableAsync();
                    return true;
                }
            )();
        }

        public abstract function initTableAsync(): Awaitable<void>;

        public function isReadyAsync(): Awaitable<bool> {
            return $this->_is_ready;
        }
    }
}
