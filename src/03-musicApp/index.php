<?hh

namespace LearnHH\MusicApp {
    use namespace LearnHH\MusicApp\Person;

    class Programmer extends Person\AbstractPerson {
        public function helloWorld(): void {
            echo 'Hello I\'m programmer.'.\PHP_EOL;
        }
    }

    function main(): void {
        $programmer =
            new Programmer('Bjarne Stroustrup', new \DateTime('1950-12-30'));
        echo $programmer->getName()['lastName'].
            ' is '.
            (string)$programmer->getAge().
            ' years old'.
            \PHP_EOL;
    }
}
