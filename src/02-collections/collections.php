<?hh
namespace LearnHH\Collections {

    use namespace HH\Lib\{C, Math, Str, Vec};

    function println(string $s): void {
        print($s.\PHP_EOL);
    }

    function str(readonly vec<mixed> $vec): string {
        $vec_str = '';
        foreach ($vec as $value) {
            $el = 'UNKNOWN_ELEMENT';
            try {
                $el = (string)$value;
            } catch (\Exception $e) {
                // pass
            }
            $vec_str = $vec_str.$el.',';
        }

        return '['.
            Str\slice($vec_str, 0, Math\max(vec[0, Str\length($vec_str) - 1])).
            ']';
    }

    function vec_operation(): void {
        $empty_vec = vec[];
        $literal_construct = vec[10, 20, 30];
        $vec = vec($empty_vec);
        println('Initial:'.str($vec));

        // push back element
        $vec[] = 1;
        println('$vec[] = 1->'.str($vec));

        // concat
        $vec = Vec\concat($vec, $literal_construct);
        println('Vec\concat($vec, $literal_construct)->'.str($vec));

        // drop
        // Returns a new vec containing all except the first `$n` elements of the
        // given Traversable.
        $vec = Vec\drop($vec, 2);
        println('Vec\drop($vec, 2)->'.str($vec));

        // contains
        println(
            'Vec\contains($vec, 10)->'.
            (C\contains($vec, 10) ? 'true' : 'false'),
        );

        // equal
        println(
            '$vec === $literal_construct->'.
            ($vec === $literal_construct ? 'true' : 'false'),
        );

        // count
        println('C\count($vec)->'.C\count($vec));

        // mutable / immutable
        mutable_vec_function(inout $vec);
        println('mutable_vec_function($vec)->'.str($vec));

        $copied_vec = imutable_vec_function($vec);
        println('$copied_vec = imutable_vec_function($vec)->'.str($copied_vec));
        println('$vec'.str($vec));

    }

    function mutable_vec_function(inout vec<mixed> $vec): void {
        $vec[] = 'inplace';
    }

    function imutable_vec_function(vec<mixed> $vec): vec<mixed> {
        $vec[] = 'copy';
        return $vec;
    }

    function main(): void {
        vec_operation();
    }
}
