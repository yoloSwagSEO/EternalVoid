<?php
    namespace Eternal\Http\Controllers;

    use Eternal\Models\Event;
    use Eternal\Libraries\Main;

    class ResearchController extends MainController {

        private $event;
        private $currentResearchJobs;

        public function __construct(Main $main, Event $event) {
            parent::__construct($main);
            $event->setCurrentUser($this->user)
                  ->setCurrentPlanet($this->planet);

            $this->event               = $event;
            $this->currentResearchJobs = $this->main->getResearchEvents();
        }

        public function getIndex() {
            $techs = $this->setTechValues();

            return view('pages.game.'.$this->game['viewpath'].'.research')->with([
                'current_research_jobs' => $this->currentResearchJobs,
                'techs'                 => $techs
            ]);
        }

        public function getStart($tech) {
            $techs = $this->setTechValues();
            if(isset($techs[$tech])) {
                if($this->event->add($techs[$tech], 2)) {
                    return redirect('research');
                }

                return redirect('research');
            }

            return redirect('research');
        }

        public function getCancel($eventId) {
            $event = $this->event->find($eventId);
            if(!is_null($event)) {
                if($event->user_id == $this->user->id && $event->type == 2) {
                    if($this->event->cancel($event)) {
                        return redirect('research');
                    }

                    return redirect('research');
                }

                return redirect('research');
            }

            return redirect('research');
        }

        private function setTechValues() {
            $techs = require_once(base_path().'/resources/data/techs.php');

            $this->currentResearchJobs->map(function($job) use (&$techs) {
                $data = unserialize($job->data);
                $techs[$data['key']]['level']++;
            });

            foreach($techs as $t => $tech) {
                foreach($tech['needs'] as $current => $required) {
                    if($current < $required) {
                        unset($techs[$t]);
                        continue(2);
                    }
                }

                $tech = $this->setResources($tech);
                $tech = $this->setResearchTime($tech);

                // Check if the build queue is full
                if($this->currentResearchJobs->count() < 3) {
                    $tech = $this->setResearchPermission($tech);
                } else {
                    $tech['build'] = false;
                }

                $tech      = $this->setResourceTime($tech);
                $techs[$t] = $tech;
            }

            return $techs;
        }

        private function setResources($tech) {
            if(isset($tech['aluminium'])) {
                $tech['aluminium'] = floor($tech['aluminium'] * pow(($this->research->{$tech['key']} + ($tech['level'] + 1)), 1.4));
            }

            if(isset($tech['titan'])) {
                $tech['titan'] = floor($tech['titan'] * pow(($this->research->{$tech['key']} + ($tech['level'] + 1)), 1.4));
            }

            if(isset($tech['silizium'])) {
                $tech['silizium'] = floor($tech['silizium'] * pow(($this->research->{$tech['key']} + ($tech['level'] + 1)), 1.4));
            }

            if(isset($tech['arsen'])) {
                $tech['arsen'] = floor($tech['arsen'] * pow(($this->research->{$tech['key']} + ($tech['level'] + 1)), 1.4));
            }

            if(isset($tech['wasserstoff'])) {
                $tech['wasserstoff'] = floor($tech['wasserstoff'] * pow(($this->research->{$tech['key']} + ($tech['level'] + 1)), 1.4));
            }

            if(isset($tech['antimaterie'])) {
                $tech['antimaterie'] = floor($tech['antimaterie'] * pow(($this->research->{$tech['key']} + ($tech['level'] + 1)), 1.4));
            }

            return $tech;
        }

        private function setResearchTime($tech) {
            $modifierOne = isset($tech['aluminium']) ? $tech['aluminium'] : 0;
            $modifierTwo = isset($tech['titan']) ? $tech['titan'] : 0;

            $tech['time'] = floor(((($modifierOne + $modifierTwo) / (1000 * (1 + $this->planet->buildings->forschungszentrum))) * 3600) / $this->game['speed']);

            return $tech;
        }

        private function setResearchPermission($tech) {
            $tech['build'] = true;

            if(isset($tech['aluminium'])) {
                $tech['build'] =  $tech['aluminium'] <= $this->resources->aluminium && $tech['build'] ? true : false;
            }

            if(isset($tech['titan'])) {
                $tech['build'] = $tech['titan'] <= $this->resources->titan && $tech['build'] ? true : false;
            }

            if(isset($tech['silizium'])) {
                $tech['build'] = $tech['silizium'] <= $this->resources->silizium && $tech['build'] ? true : false;
            }

            if(isset($tech['arsen'])) {
                $tech['build'] = $tech['arsen'] <= $this->resources->arsen && $tech['build'] ? true : false;
            }

            if(isset($tech['wasserstoff'])) {
                $tech['build'] = $tech['wasserstoff'] <= $this->resources->wasserstoff && $tech['build'] ? true : false;
            }

            if(isset($tech['antimaterie'])) {
                $tech['build'] = $tech['antimaterie'] <= $this->resources->antimaterie && $tech['build'] ? true : false;
            }

            return $tech;
        }

        private function setResourceTime($tech) {
            $data = [];

            if(isset($tech['aluminium'])) {
                $data[] = floor(($tech['aluminium'] - $this->resources->aluminium) / ($this->production->aluminium + $this->game['aluminium']));
            }

            if(isset($tech['titan'])) {
                $data[] = floor(($tech['titan'] - $this->resources->titan) / ($this->production->titan + $this->game['titan']));
            }

            if(isset($tech['silizium'])) {
                $data[] = floor(($tech['silizium'] - $this->resources->silizium) / ($this->production->silizium + $this->game['silizium']));
            }

            if(isset($tech['arsen'])) {
                if($this->production->arsen > 0) {
                    $data[] = floor(($tech['arsen'] - $this->resources->arsen) / $this->production->arsen);
                } else {
                    $data[] = 0;
                }
            }

            if(isset($tech['wasserstoff'])) {
                if($this->production->wasserstoff > 0) {
                    $data[] = floor(($tech['wasserstoff'] - $this->resources->wasserstoff) / $this->production->wasserstoff);
                } else {
                    $data[] = 0;
                }
            }

            if(isset($tech['antimaterie'])) {
                if($this->production->antimaterie > 0) {
                    $data[] = floor(($tech['antimaterie'] - $this->resources->antimaterie) / $this->production->antimaterie);
                } else {
                    $data[] = 0;
                }
            }

            $tech['restime'] = max($data);

            return $tech;
        }

    }