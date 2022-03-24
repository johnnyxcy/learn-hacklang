<?hh

namespace LearnHH\MusicApp\Song {
    use namespace LearnHH\MusicApp\Common;

    type SongSummary = shape(
        'title' => string,
        'length' => Common\TimeLength,
        'language' => Common\Language,
    );

    interface ISong {
        public function getTitle(): string;
        public function getLength(): Common\TimeLength;
        public function getLanguage(): Common\Language;

        public function summary(): string;
    }

}