<?php
    namespace Eternal\Http\Controllers;

    use Eternal\Libraries\Main;
    use Eternal\Models\Alliance;
    use Eternal\Models\AllianceRank;

    class AlliancesController extends MainController {

        private $alliance;
        private $allianceRank;
        private $playerAlliance;
        private $alliancePermissions;

        public function __construct(Main $main, Alliance $alliance, AllianceRank $allianceRank) {
            parent::__construct($main);

            $this->alliance = $alliance;
            $this->alliance->setCurrentUser($this->user);

            $this->allianceRank = $allianceRank;
            $this->allianceRank->setCurrentUser($this->user);

            $this->setPlayerAlliance()->setAlliancePermissions();
            view()->share([
                'alliance'    => $this->playerAlliance,
                'permissions' => $this->alliancePermissions,
            ]);
        }

        public function getIndex() {
            if(is_null($this->playerAlliance)) {
                $alliances = $this->alliance->read();
                return view('pages.game.'.$this->game['viewpath'].'.alliance-index')->with([
                    'alliances' => $alliances
                ]);
            }

            return view('pages.game.'.$this->game['viewpath'].'.alliance-page');
        }

        public function postCreate() {
            if($this->alliance->add()) {
                if($this->user->profile->setAlliance($this->alliance->id, $this->user->profile)) {
                    $founder = $this->allianceRank->setFounderRank($this->alliance);
                               $this->allianceRank->setMemberRank($this->alliance);

                    if($this->user->profile->setAllianceRank($founder->id, $this->user->profile)) {
                        return redirect('alliance');
                    }

                    return redirect('alliance');
                }

                return redirect('alliance');
            }

            return redirect('alliance')->withInput()
                                       ->withErrors($this->alliance->validator)
                                       ->with(['create' => true]);
        }

        public function getEdit() {
            if(!is_null($this->playerAlliance)) {
                if($this->hasPermission('edit_alliance')) {
                    return view('pages.game.'.$this->game['viewpath'].'.alliance-edit');
                }

                return redirect('alliance');
            }

            return redirect('alliance');
        }

        public function postEdit() {
            if(!is_null($this->playerAlliance)) {
                if($this->hasPermission('edit_alliance')) {
                    if($this->alliance->modify($this->playerAlliance)) {
                        return redirect('alliance/edit')->with([
                            'success' => 'Deine Allianz wurde erfolgreich bearbeitet.'
                        ]);
                    }

                    return redirect('alliance/edit')->withInput()->withErrors($this->alliance->validator);
                }

                return redirect('alliance');
            }

            return redirect('alliance');
        }

        public function getLeave() {
            if(!is_null($this->playerAlliance)) {
                if($this->user->profile->setAlliance(0, $this->user->profile) && $this->user->profile->setAllianceRank(0, $this->user->profile)) {
                    return redirect('alliance')->with([
                        'success' => 'Du hast deine Allianz soeben verlassen.'
                    ]);
                }

                return redirect('alliance')->with([
                    'error' => 'Aufgrund eines technischen Fehlers konntest du deine Allianz nicht verlassen.'
                ]);
            }

            return redirect('/');
        }

        public function getDelete() {
            if(!is_null($this->playerAlliance)) {
                if($this->hasPermission('delete_alliance')) {
                    if($this->alliance->remove($this->playerAlliance)) {
                        return redirect('alliance')->with([
                            'success' => 'Deine Allianz wurde erfolgreich gelöscht.'
                        ]);
                    }

                    return redirect('alliance')->with([
                        'error' => 'Deine Allianz konnte aufgrund eines technischen Fehlers nicht gelöscht werden.'
                    ]);
                }

                return redirect('alliance');
            }

            return redirect('alliance');
        }

        public function getDetail($allianceTag) {
            $alliance = $this->alliance->readByTag($allianceTag, ['memberCount']);
            if(!is_null($alliance)) {
                return view('pages.game.'.$this->game['viewpath'].'.alliance-detail')->with([
                    'alliance' => $alliance
                ]);
            }

            return redirect()->back()->with([
               'error' => 'Es gibt keine Allianz mit diesem TAG.'
            ]);
        }

        private function setPlayerAlliance() {
            if($this->user->profile->alliance_id !== 0) {
                $this->playerAlliance = $this->alliance->read($this->user->profile->alliance_id, ['memberCount']);

                return $this;
            }

            return null;
        }

        private function setAlliancePermissions() {
            if($this->user->profile->alliance_id !== 0) {
                $this->alliancePermissions = $this->user->profile->alliancePermissions()->get()->first()->toArray();

                return $this;
            }

            return null;
        }

        private function hasPermission($permission) {
            return (bool) $this->alliancePermissions[$permission];
        }
    }