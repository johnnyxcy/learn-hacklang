<?hh

namespace LearnHH\MusicApp\Service\DB {
    use type LearnHH\MusicApp\Service\DB\Tables\{
        ISingerSongRelsTableService,
        ISingersTableService,
        ISongsTableService,
    };

    interface IMusicDBService {
        public function isReadyAsync(): Awaitable<bool>;
        public function songs(): ISongsTableService;
        public function singers(): ISingersTableService;
        public function rels(): ISingerSongRelsTableService;
    }
}
