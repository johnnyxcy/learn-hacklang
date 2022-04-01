<?hh

namespace LearnHH\MusicApp\Service\DB\Tables {
    use namespace LearnHH\MusicApp\{Common, Model};
    use namespace HH\Lib\C;

    class SongsTableServiceImpl implements ISongsTableService {

        use _Private\TableSerivceT<Model\ISong>;

        protected static function queryResultToModel(
            Map<string, ?string> $query_d,
        ): Model\ISong {
            $uid = $query_d['UID'];
            if ($uid is null) {
                throw new \Exception();
            }

            $title = $query_d['Title'];
            if ($title is null) {
                throw new \Exception();
            }

            $data_uri = $query_d['DataUri'];
            if ($data_uri is null) {
                throw new \Exception();
            }

            $time_length = $query_d['TimeLength'];
            if ($time_length is null) {
                throw new \Exception();
            }

            $lyrics = $query_d['Lyrics'];
            if ($lyrics is null) {
                throw new \Exception();
            }

            $_language = $query_d['Language'];
            if ($_language is null) {
                throw new \Exception();
            }
            $language = Common\string_to_language($_language);

            return new Model\Song(
                $title,
                $data_uri,
                (int)$time_length,
                $lyrics,
                $language,
                $uid,
            );
        }

        <<__Override>>
        public final async function initTableAsync(): Awaitable<void> {
            await $this->db
                ->query(
                    'CREATE TABLE IF NOT EXISTS music.songs ('.
                    'UID VARCHAR(40) NOT NULL,'.
                    'Title VARCHAR(200) NOT NULL,'.
                    'DataUri VARCHAR(100) NOT NULL,'.
                    'TimeLength INT NOT NULL,'.
                    'Lyrics VARCHAR(20000),'.
                    'Language VARCHAR(10),'.
                    'PRIMARY KEY (UID)) DEFAULT CHARSET=utf8;',
                );
        }

        public async function getAllAsync(): Awaitable<vec<Model\ISong>> {
            $songs = vec[];
            foreach (
                (
                    await $this->db
                        ->query(
                            'SELECT UID, Title, DataUri, TimeLength, Lyrics, Language '.
                            'FROM music.songs',
                        )
                )->mapRows() as $_ => $d
            ) {
                $songs[] = static::queryResultToModel($d);
            }

            return $songs;
        }

        public async function getAsync(
            string $song_uid,
        ): Awaitable<Model\ISong> {
            $query_result_rows = (
                await $this->db->queryf(
                    'SELECT UID, Title, DataUri, TimeLength, Lyrics, Language '.
                    'FROM music.songs WHERE UID=%s',
                    $song_uid,
                )
            )->mapRows();

            if (C\count($query_result_rows) === 1) {
                return static::queryResultToModel($query_result_rows[0]);
            } else {
                throw new \Exception();
            }
        }

        public async function removeAsync(string $song_uid): Awaitable<bool> {
            try {
                await $this->db
                    ->queryf('DELETE FROM music.songs WHERE UID=%s', $song_uid);
                return true;
            } catch (\Exception $_) {
                return false;
            }
        }

        public async function updateAsync(Model\ISong $song): Awaitable<bool> {
            try {
                // Title, DataUri, TimeLength, Lyric, Language
                await $this->db
                    ->queryf(
                        'INSERT INTO music.songs '.
                        '(UID, Title, DataUri, TimeLength, Lyrics, Language) '.
                        'VALUES'.
                        '(%s, %s, %s, %d, %s, %s) '.
                        'ON DUPLICATE KEY UPDATE '.
                        'Title=VALUES(Title), '.
                        'DataUri=VALUES(DataUri), '.
                        'TimeLength=VALUES(TimeLength), '.
                        'Lyrics=VALUES(Lyrics), '.
                        'Language=VALUES(Language)',
                        $song->getUID(),
                        $song->getTitle(),
                        $song->getDataUri(),
                        $song->getTotalLength(),
                        $song->getLyrics(),
                        $song->getLanguage() as string,
                    );
                return true;
            } catch (\Exception $e) {
                echo $e->getMessage().\PHP_EOL;
                return false;
            }
        }
    }
}
