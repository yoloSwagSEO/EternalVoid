<?php
	namespace Eternal\Libraries;

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
				 ->eventResources();
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
			$this->interval = empty($start) && empty($end) ? time() - $this->planet->lastupdate_at : $end - $start;

			return $this;
		}

		private function eventResources() {
			$this->libResources->setGame($this->game)
							   ->setPlanet($this->planet)
							   ->setResearch($this->research);

			if(!empty($this->stack)) {
				foreach($this->stack as $item) {
					if(isset($item['production'])) {
						$this->setInterval($item['start'], ($item['end'] == 0 ? time() : $item['end']));
						$this->planet->production = $item['production'];
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

	}