<?php
    namespace Eternal\Libraries;

    class Events {

        private $game;
        private $planet;
        private $research;

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

        public function process() {
            $this->libResources->setGame($this->game)->setPlanet($this->planet)->setResearch($this->research);

            $this->libBuildings->setPlanet($this->planet)->handleEvents($this->libResources);
            $this->libResearch->setResearch($this->research)->handleEvents($this->libResources);
            $this->libResources->process();

            $this->planet->resources->save();
            $this->planet->production->save();
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

        public function getBuildingsEvents() {
            return $this->libBuildings->getEvents();
        }

        public function getResearchEvents() {
            return $this->libResearch->getEvents();
        }

    }