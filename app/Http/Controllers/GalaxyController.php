<?php
    namespace Eternal\Http\Controllers;

    use Eternal\Libraries\Main;

    use Request;

    class GalaxyController extends MainController {

        public function __construct(Main $main) {
            parent::__construct($main);
        }

        public function getIndex($galaxy = '', $system = '') {
            $galaxy = empty($galaxy) ? $this->planet->galaxy : (int) $galaxy;
            $system = empty($system) ? $this->planet->system : (int) $system;


            $planets = $this->planet->in($galaxy, $system, ['user.profile' => function($query) {
                return $query->with(['race', 'alliance']);
            }]);

            return view('pages.game.'.$this->game['viewpath'].'.galaxy')->with([
                'galaxy'  => $galaxy,
                'system'  => $system,
                'planets' => $planets
            ]);
        }

        public function postIndex() {
            $galaxy = (int) Request::get('galaxy');
            $system = (int) Request::get('system');

            foreach(Request::all() as $key => $value) {
                switch($key) {
                    case 'home':
                        $galaxy = $this->planet->galaxy;
                        $system = $this->planet->system;
                    break;
                    case 'prevgalaxy':
                        $galaxy--;
                    break;
                    case 'nextgalaxy':
                        $galaxy++;
                    break;
                    case 'prevsystem':
                        $system--;
                    break;
                    case 'nextsystem':
                        $system++;
                    break;
                }
            }

            if($system < 1) {
                $system = 255;
                $galaxy--;
            }

            if($system > 255) {
                $system = 1;
                $galaxy++;
            }

            $galaxy = $galaxy < 1 ? 4 : ($galaxy > 4 ? 1 : $galaxy);
            return $this->getIndex($galaxy, $system);
        }

    }