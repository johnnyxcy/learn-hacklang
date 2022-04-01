<?hh

namespace LearnHH\MusicApp {
    use namespace LearnHH\MusicApp\Model;
    use namespace LearnHH\MusicApp\Service\DB;
    use namespace HH\Lib\Str;

    async function main_async(): Awaitable<void> {

        $stdin = \fopen('php://stdin', 'r');
        print('MySQL port = ');
        $port = (int)Str\trim(\stream_get_line($stdin));
        print('MySQL userName = ');
        $user = Str\trim(\stream_get_line($stdin));
        print('MySQL passwd for '.$user.' = ');
        $passwd = Str\trim(\stream_get_line($stdin));
        $client = new DB\ConnectionManager($port, $user, $passwd);
        $music_db = new DB\MusicDBService($client);
        await $music_db->isReadyAsync();

        $songs_vec = await $music_db->songs()->getAllAsync();
        foreach ($songs_vec as $_ => $song) {
            print($song->getTitle().\PHP_EOL);
        }
    }
}
