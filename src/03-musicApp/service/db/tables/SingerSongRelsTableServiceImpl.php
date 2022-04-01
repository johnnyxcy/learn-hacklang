<?hh

namespace LearnHH\MusicApp\Service\DB\Tables {
    class SingerSongRelsTableImpl implements ISingerSongRelsTableService {
        private Awaitable<bool> $_is_ready;

        public function __construct(private \AsyncMysqlConnection $db) {
            $this->_is_ready = (
                async () ==> {
                    await $this->db->query(
                        'CREATE TABLE IF NOT EXISTS music.singer_song_rels ('.
                        'UID INT UNSIGNED AUTO_INCREMENT, '.
                        'SongUID VARCHAR(40) NOT NULL,'.
                        'SingerUID VARCHAR(40) NOT NULL,'.
                        'PRIMARY KEY (UID)) DEFAULT CHARSET=utf8;',
                    );
                    return true;
                }
            )();
        }

        public function isReadyAsync(): Awaitable<bool> {
            return $this->_is_ready;
        }

        public async function getSingerUIDAsync(
            string $song_uid,
        ): Awaitable<vec<string>> {
            $singer_uid_vec = vec[];

            foreach (
                (
                    await $this->db->queryf(
                        'SELECT SingerUID FROM music.singer_song_rels WHERE SongUID=%s',
                        $song_uid,
                    )
                )->mapRows() as $_ => $query_d
            ) {
                $singer_uid = $query_d['SingerUID'];
                if ($singer_uid is null) {
                    // do nothing
                } else {
                    $singer_uid_vec[] = $singer_uid;
                }
            }

            return $singer_uid_vec;
        }

        public async function getSongUIDAsync(
            string $singer_uid,
        ): Awaitable<vec<string>> {
            $song_uid_vec = vec[];

            foreach (
                (
                    await $this->db->queryf(
                        'SELECT SongUID FROM music.singer_song_rels WHERE SingerUID=%s',
                        $singer_uid,
                    )
                )->mapRows() as $_ => $query_d
            ) {
                $song_uid = $query_d['SongUID'];
                if ($song_uid is null) {
                    // do nothing
                } else {
                    $song_uid_vec[] = $song_uid;
                }
            }

            return $song_uid_vec;
        }

        public async function setRelAsync(IRel $rel): Awaitable<void> {
            await $this->db->queryf(
                'INSERT INTO music.singer_song_rels (SongUID, SingerUID) VALUES (%s, %s)',
                $rel['song_uid'],
                $rel['singer_uid'],
            );
        }

        public async function removeRelAsync(IRel $rel): Awaitable<void> {
            await $this->db->queryf(
                'DELETE FROM music.singer_song_rels WHERE SongUID=%s AND SingerUID=%s',
                $rel['song_uid'],
                $rel['singer_uid'],
            );
        }
    }
}
