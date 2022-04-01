<?hh

namespace LearnHH\MusicApp\Service\DB\Tables {
    use namespace LearnHH\MusicApp\Model;
    use namespace HH\Lib\C;

    class SingersTableServiceImpl implements ISingersTableService {
        use _Private\TableSerivceT<Model\ISinger>;
        protected static function queryResultToModel(
            Map<string, ?string> $query_d,
        ): Model\ISinger {
            $uid = $query_d['UID'];
            if ($uid is null) {
                throw new \Exception();
            }

            $name = $query_d['Name'];
            if ($name is null) {
                throw new \Exception();
            }

            $_birthday = $query_d['Birthday'];
            if ($_birthday is null) {
                throw new \Exception();
            }
            $birthday = new \DateTime($_birthday);

            $description = $query_d['Description'];
            if ($description is null) {
                throw new \Exception();
            }

            return new Model\Singer($name, $birthday, $description, $uid);
        }

        <<__Override>>
        public final async function initTableAsync(): Awaitable<void> {
            await $this->db
                ->query(
                    'CREATE TABLE IF NOT EXISTS music.singers ('.
                    'UID VARCHAR(40) NOT NULL,'.
                    'Name VARCHAR(100) NOT NULL,'.
                    'Birthday DATE,'.
                    'Description VARCHAR(8000),'.
                    'PRIMARY KEY (UID)) DEFAULT CHARSET=utf8;',
                );
        }

        public async function getAllAsync(): Awaitable<vec<Model\ISinger>> {
            $singers = vec[];
            foreach (
                (
                    await $this->db->query(
                        'SELECT UID, Name, Birthday, Description '.
                        'FROM music.singers',
                    )
                )->mapRows() as $_ => $d
            ) {
                $singers[] = static::queryResultToModel($d);
            }
            return $singers;
        }

        public async function getAsync(
            string $singer_uid,
        ): Awaitable<Model\ISinger> {
            $query_result_rows = (
                await $this->db->queryf(
                    'SELECT UID, Name, Birthday, Description '.
                    'FROM music.singers WHERE UID=%s',
                    $singer_uid,
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
                    ->queryf(
                        'DELETE FROM music.singers WHERE UID=%s',
                        $song_uid,
                    );
                return true;
            } catch (\Exception $_) {
                return false;
            }
        }

        public async function updateAsync(
            Model\ISinger $singer,
        ): Awaitable<bool> {
            try {
                // Title, DataUri, TimeLength, Lyric, Language
                await $this->db
                    ->queryf(
                        'INSERT INTO music.singers '.
                        '(UID, Name, Birthday, Description) '.
                        'VALUES'.
                        '(%s, %s, %s, %s) '.
                        'ON DUPLICATE KEY UPDATE '.
                        'Name=VALUES(Name), '.
                        'Birthday=VALUES(Birthday), '.
                        'Description=VALUES(Description)',
                        $singer->getUID(),
                        $singer->getName(),
                        $singer->getBirthday()->format('Y-m-d'),
                        $singer->getDescription(),
                    );
                return true;
            } catch (\Exception $e) {
                echo $e->getMessage().\PHP_EOL;
                return false;
            }
        }
    }

}
