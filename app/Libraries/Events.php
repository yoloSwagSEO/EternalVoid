<?php
    namespace Eternal\Libraries;

    use Carbon\Carbon;

    class Events {

        private $game;
        private $planet;
        private $research;
        private $interval;
        private $stack = [];

        private $libResources;
        private $libBuildings;
        private $libResearch;
        private $libUnits;
        private $libFleets;

        public function __construct(
            Resources $resources,
            Buildings $buildings,
            Research $research,
            Units $units,
            Fleets $fleets
        ) {
            $this->libResources = $resources;
            $this->libBuildings = $buildings;
            $this->libResearch  = $research;
            $this->libUnits 	= $units;
            $this->libFleets	= $fleets;
        }

        public function init() {
            $this->setInterval()
                 ->eventBuildings()
                 ->eventResources();
        }

        private function eventBuildings() {
            $this->libBuildings->setStack($this->stack)
                               ->setPlanet($this->planet)
                               ->handleEvents();

            $this->stack = $this->libBuildings->getStack();
            return $this;
        }

        private function eventResources() {
            $this->libResources->setGame($this->game)
                               ->setPlanet($this->planet)
                               ->setResearch($this->research);

            if(!empty($this->stack)) {
                foreach($this->stack as $item) {
                    if(isset($item['production'])) {
                        $this->setInterval($item['start'], (!is_object($item['end']) ? Carbon::now() : $item['end']));
                        $this->libResources->setPlanet($this->planet)
                                           ->process($this->interval);
                    }
                }

                $this->planet->production->save();
            } else {
                $this->libResources->process($this->interval);
            }

            $this->planet->resources->save();

            return $this;
        }

        public function setGame($game) {
            $this->game = $game;

            return $this;
        }

        public function setPlanet($planet) {
            $this->planet = $planet;

            return $this;
        }

        public function setResearch($research) {
            $this->research = $research;

            return $this;
        }

        private function setInterval($start = '', $end = '') {
            $now = Carbon::now();
            $this->interval = empty($start) && empty($end) ? $now->diffInSeconds($this->planet->lastupdate_at) : $end->diffInSeconds($start);

            return $this;
        }

        public function getBuildingsEvents() {
            return $this->libBuildings->getEvents();
        }

    }