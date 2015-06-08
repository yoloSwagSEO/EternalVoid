<?php
	namespace Eternal\Libraries;

	use Carbon\Carbon;
	use Eternal\Models\Event;

	class Buildings {

		private $event;
		private $events;
		private $planet;
		private $stack;

		public function __construct(Event $event) {
			$this->event = $event;
		}

		public function handleEvents() {
			$this->events = $this->event->read($this->planet->user_id, 1, $this->planet->id);
			foreach($this->events as $event) {
				$data = unserialize($event->data);

				if(Carbon::now()->gte($event->finished_at)) {
					$this->planet->buildings->{$data['key']}++;
					$this->planet->buildings->save();
					$this->planet->pkt++;
					$this->planet->save();

					if(isset($data['production'])) {
						if(end($this->stack) === false) {
							$this->stack[] = [
								'start'      => $this->planet->lastupdate_at,
								'end'        => $event->finished_at,
								'production' => $this->planet->production
							];

							$this->stack[] = [
								'start'      => $event->finished_at,
								'end'        => 0,
								'production' => $this->calculateNewProduction($data)
							];

						} else {
							$this->stack[key($this->stack)]['end'] = $event->finished_at;
							$this->stack[] = [
								'start'      => $event->finished_at,
								'end'        => 0,
								'production' => $this->calculateNewProduction($data)
							];
						}
					}

					$this->event->remove($event);
					$item = $this->events->shift();
					unset($item);
				} else {
					$data['remaining'] = Carbon::now()->diffInSeconds($event->finished_at);
					$this->event->modify($event, $data);
				}
			}
		}

		private function calculateNewProduction($data) {
			$production = $data['production'] / 3600;

			if($data['key'] == 'aluminiummine') $this->planet->production->aluminium = $production;
			if($data['key'] == 'titanfertigung') $this->planet->production->titan = $production;
			if($data['key'] == 'siliziummine') $this->planet->production->silizium = $production;
			if($data['key'] == 'arsenfertigung') $this->planet->production->arsen = $production;
			if($data['key'] == 'wasserstofffabrik') $this->planet->production->wasserstoff = $production;
			if($data['key'] == 'antimateriefabrik') $this->planet->production->antimaterie = $production;

			return $this->planet->production;
		}

		public function setStack($stack) {
			$this->stack = $stack;
			return $this;
		}

		public function getStack() {
			return $this->stack;
		}

		public function setPlanet($planet) {
			$this->planet = $planet;
			return $this;
		}

		public function getEvents() {
			return $this->events;
		}
	}