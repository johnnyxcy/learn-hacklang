<?hh

namespace LearnHH\MusicApp {
    use namespace LearnHH\MusicApp\Service\DB;
    use namespace LearnHH\MusicApp\Service;
    use namespace HH\Lib\Str;

    async function main_async(): Awaitable<void> {
        $stdin = \fopen('php://stdin', 'r');
        print('MySQL port = ');
        $port = (int)Str\trim(\stream_get_line($stdin));
        print('MySQL userName = ');
        $user = Str\trim(\stream_get_line($stdin));
        print('MySQL passwd for '.$user.' = ');
        $passwd = Str\trim(\stream_get_line($stdin));
        $client = new DB\ConnectionManagerImpl($port, $user, $passwd);
        $music_db = new DB\MusicDBServiceImpl($client);
        $main_service = new Service\MusicMainSerivceImpl($music_db);
        await $main_service->awaitReadyAsync();
    }
}
