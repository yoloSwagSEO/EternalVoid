<?php
    namespace Eternal\Http\Controllers;

    class MainController extends Controller {

        protected $main;
        protected $game;
        protected $user;
        protected $planet;
        protected $resources;
        protected $production;
        protected $research;
        protected $helper;

        /**
         * @param $main \Eternal\Libraries\Main
         */
        public function __construct($main) {
            $this->main 	  = $main;
            $this->game 	  = $main->getGame();
            $this->user 	  = $main->getUser();
            $this->planet     = $main->getPlanet();
            $this->resources  = $main->getResources();
            $this->production = $main->getProduction();
            $this->research   = $main->getResearch();
            $this->helper	  = $main->getHelper();

            $this->setupLayout();
        }

        public function setupLayout() {
            $newmessage = false;
            foreach($this->user->messages as $msg) {
                if(is_null($msg->read_at)) {
                    $newmessage = true;
                    break;
                }
            }

            view()->share([
                'help' 		 => $this->helper,
                'game' 		 => $this->game,
                'user' 		 => $this->user,
                'planet'	 => $this->planet,
                'resources'  => $this->resources,
                'production' => $this->production,
                'research' 	 => $this->research,
                'newmessage' => $newmessage,
            ]);
        }

    }