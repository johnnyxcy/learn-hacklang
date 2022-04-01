<?hh

namespace LearnHH\MusicApp\Model {
    class Person {
        public function __construct(
            private string $name,
            private \DateTime $birthday,
        ) {}

        public final function getName(): string {
            return $this->name;
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

    interface IPerson {
        require extends Person;
    }

    trait PersonTrait {
        require extends Person;
        require implements IPerson;
    }
}
