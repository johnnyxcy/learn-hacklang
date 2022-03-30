<?hh

namespace LearnHH\MusicApp\Model {
    abstract class AbstractPerson {
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

    trait PersonTrait {
        require extends AbstractPerson;
    }

    interface IPerson {
        require extends AbstractPerson;
    }
}
