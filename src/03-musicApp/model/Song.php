<?hh // strict

namespace LearnHH\MusicApp\Model {
    use namespace LearnHH\MusicApp\Common;

    interface ISong {
        public function getUID(): string;
        public function getDataUri(): string;
        public function getTitle(): string;
        public function getTotalLength(): int;
        public function getLyrics(): string;
        public function getLanguage(): Common\Language;
    }

    class Song implements ISong {
        private string $uuid;
        private Common\Language $language;
        public function __construct(
            private string $title,
            private string $data_uri,
            private int $time_length,
            private string $lyrics,
            ?Common\Language $language = null,
            ?string $uuid = null,
        ) {
            $this->language = $language ?? Common\string_to_language('Chinese');
            $this->uuid = $uuid ?? generate_uuid();
        }

        public function __toString(): string {
            return 'Song<'.$this->title.'>';
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

        public function getTotalLength(): int {
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
