<?hh // strict

namespace LearnHH\MusicApp\Model {
    use namespace LearnHH\MusicApp\Common;

    interface ISong {
        public function getUID(): string;
        public function getDataUri(): string;
        public function getTitle(): string;
        public function getTotalLength(): Common\TimeDelta;
        public function getLyrics(): string;
        public function getLanguage(): Common\Language;
    }

    class Song implements ISong {
        private string $uuid;
        public function __construct(
            private string $title,
            private string $data_uri,
            private Common\TimeDelta $time_length,
            private string $lyrics,
            private Common\Language $language = Common\Language::CN,
        ) {
            $this->uuid = generate_uuid();
        }

        public function getUID(): string {
            return $this->uuid;
        }

        public function getDataUri(): string {
            return $this->data_uri;
        }

        public function getTitle(): string {
            return $this->title;
        }

        public function getTotalLength(): Common\TimeDelta {
            return $this->time_length;
        }

        public function getLanguage(): Common\Language {
            return $this->language;
        }

        public function getLyrics(): string {
            return $this->lyrics;
        }
    }
}
