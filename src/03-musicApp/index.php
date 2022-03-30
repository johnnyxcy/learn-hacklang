<?hh

namespace LearnHH\MusicApp {

    // class Programmer extends Person\AbstractPerson {
    //     public function helloWorld(): void {
    //         echo 'Hello I\'m programmer.'.\PHP_EOL;
    //     }
    // }
    use namespace LearnHH\MusicApp\Services\DB;
    use namespace HH\Lib\{SQL, Str};

    async function main_async(): Awaitable<void> {
        $stdin = \fopen('php://stdin', 'r');
        print('MySQL port = ');
        $port = (int)Str\trim(\stream_get_line($stdin));
        print('MySQL userName = ');
        $user = Str\trim(\stream_get_line($stdin));
        print('MySQL passwd for '.$user.' = ');
        $passwd = Str\trim(\stream_get_line($stdin));
        using ($client = new DB\ConnectionManager($port, $user, $passwd)) {
            await $client->connectAsync('mysql');
            if ($client->isConnected('mysql')) {
                $result = await $client->get('mysql')
                    ->queryAsync(new SQL\Query('SELECT User from mysql.user'));
                foreach ($result->mapRows() as $row_index => $mapping) {
                    print($row_index.',');
                    if ($mapping) {
                        foreach ($mapping as $key => $val) {
                            print($key.','.$val);
                        }
                    }
                    print(\PHP_EOL);
                }
            }
        }
        // $programmer =
        //     new Programmer('Bjarne Stroustrup', new \DateTime('1950-12-30'));
        // echo $programmer->getName()['lastName'].
        //     ' is '.
        //     (string)$programmer->getAge().
        //     ' years old'.
        //     \PHP_EOL;
    }
}
