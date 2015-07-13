<?php
    namespace Eternal\Http\Controllers;

    use Eternal\Libraries\Main;

    class PlanetsController extends MainController {

        public function __construct(Main $main) {
            parent::__construct($main);
        }

        public function getIndex() {
            return view('pages.game.'.$this->game['viewpath'].'.planet');
        }

        public function getDetail($galaxy, $system, $position) {
            $planet = $this->planet->readByCoordinates($galaxy, $system, $position, ['user'])->first();
            return view('pages.game.'.$this->game['viewpath'].'.planet-detail')->with([
                'plt' => $planet
            ]);
        }

    }