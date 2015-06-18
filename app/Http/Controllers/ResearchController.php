<?php
    namespace Eternal\Http\Controllers;

    use Eternal\Models\Event;
    use Eternal\Libraries\Main;

    /**
     * Class ResearchController
     * @package Eternal\Http\Controllers
     *
     * @var \Eternal\Models\Event $event
     * @var \Illuminate\Database\Eloquent\Collection $currentResearchJobs
     */

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
            $tech['aluminium'] = floor($tech['aluminium'] * pow(($this->research->{$tech['key']} + ($tech['level'] + 1)), 1.4));
            $tech['titan'] = floor($tech['titan'] * pow(($this->research->{$tech['key']} + ($tech['level'] + 1)), 1.4));
            $tech['silizium'] = floor($tech['silizium'] * pow(($this->research->{$tech['key']} + ($tech['level'] + 1)), 1.4));
            $tech['arsen'] = floor($tech['arsen'] * pow(($this->research->{$tech['key']} + ($tech['level'] + 1)), 1.4));
            $tech['wasserstoff'] = floor($tech['wasserstoff'] * pow(($this->research->{$tech['key']} + ($tech['level'] + 1)), 1.4));
            $tech['antimaterie'] = floor($tech['antimaterie'] * pow(($this->research->{$tech['key']} + ($tech['level'] + 1)), 1.4));

            return $tech;
        }

        private function setResearchTime($tech) {
            $modifierOne = $tech['aluminium'];
            $modifierTwo = $tech['titan'];

            $tech['time'] = floor(((($modifierOne + $modifierTwo) / (1000 * (1 + $this->planet->buildings->forschungszentrum))) * 3600) / $this->game['speed']);

            return $tech;
        }

        private function setResearchPermission($tech) {
            $tech['build'] = $tech['aluminium'] <= $this->resources->aluminium &&
                             $tech['titan'] <= $this->resources->titan &&
                             $tech['silizium'] <= $this->resources->silizium &&
                             $tech['arsen'] <= $this->resources->arsen &&
                             $tech['wasserstoff'] <= $this->resources->wasserstoff &&
                             $tech['antimaterie'] <= $this->resources->antimaterie ? true : false;

            return $tech;
        }

        private function setResourceTime($tech) {
            $data = [
                floor(($tech['aluminium'] - $this->resources->aluminium) / ($this->production->aluminium + $this->game['aluminium'])),
                floor(($tech['titan'] - $this->resources->titan) / ($this->production->titan + $this->game['titan'])),
                floor(($tech['silizium'] - $this->resources->silizium) / ($this->production->silizium + $this->game['silizium'])),
                $this->production->arsen > 0 ? floor(($tech['arsen'] - $this->resources->arsen) / $this->production->arsen) : 0,
                $this->production->wasserstoff > 0 ? floor(($tech['wasserstoff'] - $this->resources->wasserstoff) / $this->production->wasserstoff) : 0,
                $this->production->antimaterie > 0 ? floor(($tech['antimaterie'] - $this->resources->antimaterie) / $this->production->antimaterie) : 0
            ];

            $tech['restime'] = max($data);

            return $tech;
        }

    }