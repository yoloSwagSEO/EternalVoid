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

			return view('pages.game.'.$this->game['viewpath'].'.galaxy')->withGalaxy($galaxy)
																		->withSystem($system)
																		->withPlanets($planets);
		}

		public function postIndex() {
			$galaxy = Request::exists('home') ? $this->planet->galaxy : (int) Request::get('galaxy');
			$system = Request::exists('home') ? $this->planet->system : (int) Request::get('system');

			$galaxy = Request::exists('prevgalaxy') ? $galaxy-1 : (Request::exists('nextgalaxy') ? $galaxy+1 : $galaxy);
			$system = Request::exists('prevsystem') ? $system-1 : (Request::exists('nextsystem') ? $system+1 : $system);

			if($system < 1) {
				$system = 255;
				$galaxy--;
			} elseif($system > 255) {
				$system = 1;
				$galaxy++;
			}

			$galaxy = $galaxy < 1 ? 4 : ($galaxy > 4 ? 1 : $galaxy);
			return $this->getIndex($galaxy, $system);
		}

	}