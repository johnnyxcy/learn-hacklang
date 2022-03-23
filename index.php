<?hh // strict

namespace LearnHH {


    <<__EntryPoint>>
    function main(): void {
        require_once(__DIR__.'/vendor/autoload.hack');

        \Facebook\AutoloadMap\initialize();
        $args = vec(\HH\global_get('argv') as Container<_>);
        if (\count($args) < 2) {
            \LearnHH\HelloWorld\main();
        } else {
            switch ($args[1]) {
                case 'helloWorld':
                    \LearnHH\HelloWorld\main();
                    break;
                case 'collections':
                    \LearnHH\Collections\main();
                    break;
                default:
                    throw new \Exception("Not Implemented", 1);
            }

        }
    }
}