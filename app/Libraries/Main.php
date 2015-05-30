<?php
	namespace Eternal\Libraries;

	use Auth;
	use Config;
	use Eternal\Models\User;
	use Eternal\Models\Planet;

	class Main {

		private $game;
		private $user;
		private $planet;
		private $helper;

		public function __construct(User $user, Planet $planet, Helper $helper) {
			$this->setGame()
				 ->setUser($user)
				 ->setPlanet($planet);

			$this->helper = $helper;
		}

		private function setGame() {
			$this->game = config()->get('game.'.session('universe'));

			return $this;
		}

		private function setUser(User $user) {
			$this->user = $user->read(Auth::user()->id, [
				'profile' => function($query) {	return $query->with(['race']); },
				'research',
				'messages'
			]);

			return $this;
		}

		private function setPlanet(Planet $planet) {
			$this->planet = $planet->read('', $this->user->id, ['production', 'resources']);

			return $this;
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