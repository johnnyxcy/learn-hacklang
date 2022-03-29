<?hh

namespace LearnHH\MusicApp\Model\Singer {
    use namespace LearnHH\MusicApp\Model\{Person, Song};

    interface ISinger extends Person\IPerson {
        public function getSongs(): vec<Song\ISong>;
        public function getDescription(): string;
    }
}
