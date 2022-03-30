<?hh

namespace LearnHH\MusicApp\Model {
    use namespace HH\Lib\Str;

    function generate_uuid(int $random_bytes = 16): string {
        $strong_result = null;
        $bytes =
            \openssl_random_pseudo_bytes($random_bytes, inout $strong_result);

        $bytes[6] = \chr(\ord($bytes[6]) & 0x0f | 0x40);
        $bytes[8] = \chr(\ord($bytes[8]) & 0x3f | 0x80);

        return
            \vsprintf('%s%s-%s-%s-%s-%s%s%s', Str\chunk(\bin2hex($bytes), 4));
    }
}
