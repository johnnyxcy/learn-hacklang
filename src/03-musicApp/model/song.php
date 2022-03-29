<?hh // strict

namespace LearnHH\MusicApp\Model\Song {
    use namespace LearnHH\MusicApp\Common;

    interface ISong {
        public function getDataUri(): string;
        public function getTitle(): string;
        public function getTotalLength(): Common\TimeDelta;
        public function getLyrics(): string;
        public function getLanguage(): Common\Language;
    }

    class Song implements ISong {
        public function __construct(
            private string $title,
            private string $dataUri,
            private Common\TimeDelta $timeLength,
            private string $lyrics,
            private Common\Language $language = Common\Language::CN,
        ) {}

        public function getDataUri(): string {
            return $this->dataUri;
        }

        public function getTitle(): string {
            return $this->title;
        }

        public function getTotalLength(): Common\TimeDelta {
            return $this->timeLength;
        }

        public function getLanguage(): Common\Language {
            return $this->language;
        }

        public function getLyrics(): string {
            return $this->lyrics;
        }
    }
}
