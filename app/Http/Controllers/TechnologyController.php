<?php
    namespace Eternal\Http\Controllers;

    use Eternal\Libraries\Main;

    class TechnologyController extends MainController {

        public function __construct(Main $main) {
            parent::__construct($main);
        }

        public function getIndex() {
            $buildings = $this->planet->buildings;
            $defenses  = $this->planet->defenses;
            $units     = $this->planet->units;

            return view('pages.game.'.$this->game['viewpath'].'.technology')->with([
                'buildings' => $buildings,
                'defenses'  => $defenses,
                'units'     => $units,
            ]);
        }

    }