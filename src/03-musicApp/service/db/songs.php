<?hh

namespace LearnHH\MusicApp\Services\DB {
    use namespace LearnHH\MusicApp\Model\Song;
    use namespace LearnHH\MusicApp\Services\DB\Connection;

    interface ISongsDB {
        public function addAsync(Song\ISong $song): Awaitable<bool>;
        public function deleteAsync(Song\ISong $song): Awaitable<bool>;
        public function getAsync(string $title): Awaitable<Song\ISong>;
    }

    // class SongsDB implements ISongsDB {
    //     use Connection\SQLTrait;

    //     public function addAsync(Song\ISong $song): Awaitable<bool> {
    //         $this->sql->queryAsync('SELECT ');
    //     }

    //     public function deleteAsync(Song\ISong $song): Awaitable<bool>;
    //     public function getAsync(string $title): Awaitable<Song\ISong>;
    // }
}