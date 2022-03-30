<?hh

namespace LearnHH\MusicApp\Model {

    interface ISinger extends IPerson {
        public function getUID(): string;
        public function getSongIDs(): vec<string>;
        public function getDescription(): string;
    }
}
