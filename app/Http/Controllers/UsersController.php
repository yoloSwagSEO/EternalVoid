<?php
    namespace Eternal\Http\Controllers;

    use Eternal\Models\User;
    use Eternal\Models\UserProfile;
    use Eternal\Models\Planet;
    use Eternal\Models\Resource;
    use Eternal\Models\Research;
    use Eternal\Models\Production;
    use Eternal\Models\Building;
    use Eternal\Models\Defense;
    use Eternal\Models\Unit;

    use Request;

    class UsersController extends Controller {

        private $user;
        private $userProfile;
        private $planet;
        private $resource;
        private $research;
        private $production;
        private $building;
        private $defense;
        private $unit;

        public function __construct(
            User $user,
            UserProfile $userProfile,
            Planet $planet,
            Resource $resource,
            Research $research,
            Production $production,
            Building $building,
            Defense $defense,
            Unit $unit
        ) {
            $this->user 	   = $user;
            $this->userProfile = $userProfile;
            $this->planet 	   = $planet;
            $this->resource    = $resource;
            $this->research	   = $research;
            $this->production  = $production;
            $this->building	   = $building;
            $this->defense	   = $defense;
            $this->unit		   = $unit;
        }

        public function getRegister() {
            return view('pages.users.register');
        }

        public function postRegister() {
            if($this->user->register()) {

                // Pick a random planet
                $planet = $this->planet->random();

                // Create default user profile
                $this->userProfile->add($this->user);

                // Set default user techs
                $this->research->add($this->user);

                // Set users start planet
                $this->planet->setUser($planet, $this->user);

                // Set default planet resources
                $this->resource->add($planet);

                // Set default planet production
                $this->production->add($planet);

                // Set default planet buildings
                $this->building->add($planet);

                // Set default planet defenses
                $this->defense->add($planet);

                // Set default planet units
                $this->unit->add($planet);

                return redirect('earlyaccess')->with([
                    'success' => trans('users.messages.register_success')
                ]);
            }

            return redirect('earlyaccess')->withErrors($this->user->validator)->withInput();
        }

        public function getLogin() {
            return view('pages.users.login');
        }

        public function postLogin() {
            if($this->user->login()) {
                return redirect('http://'.session('universe').'.'.Request::getHttpHost().'/');
            }

            return redirect('earlyaccess')->withErrors($this->user->validator)->withInput();
        }

        public function getLogout() {
            if($this->user->logout()) {
                return redirect('/')->with([
                    'success' => trans('users.messages.logout_success')
                ]);
            }

            return redirect('/');
        }

    }