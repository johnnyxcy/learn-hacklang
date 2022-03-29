<?hh

namespace LearnHH\MusicApp {

    // class Programmer extends Person\AbstractPerson {
    //     public function helloWorld(): void {
    //         echo 'Hello I\'m programmer.'.\PHP_EOL;
    //     }
    // }
    use namespace LearnHH\MusicApp\Services\DB\Connection;
    use namespace HH\Lib\{SQL, Str};

    async function main_async(): Awaitable<void> {
        $stdin = \fopen('php://stdin', 'r');
        print('MySQL port = ');
        $port = (int)Str\trim(\stream_get_line($stdin));
        print('MySQL userName = ');
        $user = Str\trim(\stream_get_line($stdin));
        print('MySQL passwd for '.$user.' = ');
        $passwd = Str\trim(\stream_get_line($stdin));
        using (
            $db = new Connection\DBConnectionService($port, $user, $passwd)
        ) {
            await $db->connectAsync('mysql');
            if ($db->isConnected('mysql')) {
                $result = await $db->get('mysql')
                    ->queryAsync(new SQL\Query('SELECT User from mysql.user'));
                foreach ($result->mapRows() as $rowIndex => $mapping) {
                    print($rowIndex.',');
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
