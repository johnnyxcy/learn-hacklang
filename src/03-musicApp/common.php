<?hh

namespace LearnHH\MusicApp\Common {
    type TimeLength = shape('minute' => int, 'second' => int);

    enum Language: string {
        CN = 'Chinese';
        EN = 'English';
        JP = 'Japanese';
        UNKNOWN = 'UNKNOWN';
    }
}
