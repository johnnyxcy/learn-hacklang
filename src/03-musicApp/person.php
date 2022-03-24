<?hh

namespace LearnHH\MusicApp\Person {
    use namespace HH\Lib\{C, Str};

    type IName = shape(
        'firstName' => ?string,
        'lastName' => ?string,
        'fullName' => string,
    );

    function create_name(string $fullName): IName {
        $vec = Str\split($fullName, ' ');
        if (C\count($vec) === 2) {
            return shape(
                'fullName' => $fullName,
                'firstName' => $vec[0],
                'lastName' => $vec[1],
            );
        } else {
            return shape(
                'fullName' => $fullName,
                'firstName' => null,
                'lastName' => null,
            );
        }
    }

    interface IPerson {
        public function getName(): IName;
        public function getFullName(): string;
        public function getAge(): int;
        public function getBirthday(): \DateTimeImmutable;
    }

    abstract class AbstractPerson implements IPerson {
        private IName $name;
        public function __construct(
            string $fullName,
            private \DateTime $birthday,
        ) {
            $this->name = create_name($fullName);
        }

        public final function getName(): IName {
            return $this->name;
        }

        public final function getFullName(): string {
            return $this->name['fullName'];
        }

        public final function getAge(): int {
            return (int)$this->birthday
                ->diff(new \DateTime('now'))
                ->format('%Y');
        }

        public final function getBirthday(): \DateTimeImmutable {
            return \DateTimeImmutable::createFromMutable($this->birthday);
        }
    }
}
