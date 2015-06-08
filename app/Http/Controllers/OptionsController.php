<?php
    namespace Eternal\Http\Controllers;

    use Eternal\Libraries\Main;

    class OptionsController extends MainController {

        public function __construct(Main $main) {
            parent::__construct($main);
        }

        public function getPlanetimages() {
            if($this->user->profile->setPlanetimages($this->user->profile)) {
                return redirect()->back();
            }

            return redirect()->back();
        }


    }