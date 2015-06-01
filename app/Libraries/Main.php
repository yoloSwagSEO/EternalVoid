<?php
	namespace Eternal\Libraries;

	use Auth;
	use Eternal\Models\User;
	use Eternal\Models\Planet;

	class Main {

		private $game;
		private $events;
		private $user;
		private $planet;
		private $helper;

		public function __construct(User $user, Planet $planet, Events $events, Helper $helper) {
			$this->setGame($user)
				 ->setUser($user)
				 ->setPlanet($planet)
				 ->setEvents($events);

			$this->helper = $helper;
			$planet->setLastupdate($this->planet);
		}

		private function setGame(User $user) {
			$users      = $user->getAll();

			$this->game = config()->get('game.'.session('universe'));
			$this->game['users']  = $users->count();
			$this->game['online'] = $users->filter(function($usr) {
				return time() - $usr->lastactive_at < 120 ? $usr : null;
			})->count();

			return $this;
		}

		private function setUser(User $user) {
			$this->user = $user->read(Auth::user()->id, [
				'profile' => function($query) {	return $query->with(['race']); },
				'research',
				'messages'
			]);

			$user->setLastactive($this->user->first());

			return $this;
		}

		private function setPlanet(Planet $planet) {
			$this->planet = $planet->read('', $this->user->id, ['production', 'resources']);

			return $this;
		}

		private function setEvents(Events $events) {
			$this->events = $events;
			$this->events->setGame($this->game)
						 ->setPlanet($this->planet)
						 ->setResearch($this->user->research)
						 ->init();
		}

		public function getGame() {
			return $this->game;
		}

		public function getUser() {
			return $this->user;
		}

		public function getResearch() {
			return $this->user->research;
		}

		public function getPlanet() {
			return $this->planet;
		}

		public function getResources() {
			return $this->planet->resources;
		}

		public function getProduction() {
			return $this->planet->production;
		}

		public function getHelper() {
			return $this->helper;
		}
	}