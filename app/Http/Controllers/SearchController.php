<?php
    namespace Eternal\Http\Controllers;

    use Request;

    use Eternal\Libraries\Main;
    use Eternal\Models\User;
    use Eternal\Models\Planet;
    use Eternal\Models\Alliance;

    class SearchController extends MainController {

        protected $mUser;
        protected $mPlanet;
        protected $mAlliance;

        public function __construct(Main $main, User $user, Planet $planet, Alliance $alliance) {
            parent::__construct($main);

            $this->mUser     = $user;
            $this->mPlanet   = $planet;
            $this->mAlliance = $alliance;
        }

        public function getIndex() {
            return view('pages.game.'.$this->game['viewpath'].'.search');
        }

        public function postIndex() {
            if(!empty(Request::get('searchterm'))) {

                $view = view('pages.game.' . $this->game['viewpath'] . '.search-result');
                switch(Request::get('searchtype')) {
                    case 'user':
                        $users = $this->mUser->search();
                        $view->with(['results' => $users]);
                    break;
                    case 'alliance':
                        $alliances = $this->mAlliance->search();
                        $view->with(['results' => $alliances]);
                    break;
                    case 'planet':
                        $planets = $this->mPlanet->search();
                        $view->with(['results' => $planets]);
                    break;
                }

                return $view->with([
                    'searchterm' => Request::get('searchterm'),
                    'searchtype' => Request::get('searchtype')
                ]);
            }

            return redirect('search')->with([
                'error' => 'Bitte gebe einen Suchbegriff ein.'
            ]);
        }
    }