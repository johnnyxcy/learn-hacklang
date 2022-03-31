<?hh

namespace LearnHH\MusicApp\Common {

    // use namespace HH\Lib\{C, Str};

    // type TimeDelta = shape('minute' => int, 'second' => int);

    // function time_delta_to_string(TimeDelta $time_delta): string {
    //     return $time_delta['minute'].':'.$time_delta['second'];
    // }

    // function string_to_time_delta(string $time_string): TimeDelta {
    //     $_time_length_tuple = Str\split($time_string, ':');
    //     if (C\count($_time_length_tuple) !== 2) {
    //         throw new \Exception();
    //     }

    //     return shape(
    //         'minute' => (int)$_time_length_tuple[0],
    //         'second' => (int)$_time_length_tuple[1],
    //     );

    // }

    enum Language: string {
        CN = 'Chinese';
        EN = 'English';
        JP = 'Japanese';
        UNKNOWN = 'UNKNOWN';
    }

    function string_to_language(string $lang): Language {
        switch ($lang) {
            case 'Chinese':
                return Language::CN;
            case 'English':
                return Language::EN;
            case 'Janpanese':
                return Language::JP;
            case 'UNKNOWN':
                return Language::UNKNOWN;
            default:
                throw new \Exception();
        }

    }
}
