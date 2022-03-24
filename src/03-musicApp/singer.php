<?hh

namespace LearnHH\MusicApp {
    use namespace LearnHH\MusicApp\Song;

    interface IPerson {
        public function getName(): string;
        public function getAge(): int;
        public function getBirthday(): \DateTime;
    }

    interface ISinger extends IPerson {
        public function getSongs(): vec<Song\ISong>;
        public function getDescription(): string;
    }
}
