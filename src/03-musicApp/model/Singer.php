<?hh

namespace LearnHH\MusicApp\Model {

    interface ISinger extends IPerson {
        public function getUID(): string;
        public function getDescription(): string;
    }

    class Singer extends Person implements ISinger {
        private string $uid;
        private string $description;
        public function __construct(
            private string $name,
            private \DateTime $birthday,
            ?string $description,
            ?string $uid,
        ) {
            parent::__construct($name, $birthday);
            $this->description =
                $description ?? '这个人很懒，什么都没写';
            $this->uid = $uid ?? generate_uuid();
        }

        public function getUID(): string {
            return $this->uid;
        }

        public function getDescription(): string {
            return $this->description;
        }
    }
}
