<?php
    namespace Eternal\Http\Controllers;

    use Eternal\Models\Event;
    use Eternal\Libraries\Main;

    /**
     * Class BuildingsController
     * @package Eternal\Http\Controllers
     *
     * @var \Eternal\Models\Event $event
     * @var \Illuminate\Database\Eloquent\Collection $currentBuildJobs
     */

    class BuildingsController extends MainController {

        private $event;
        private $currentBuildJobs;

        public function __construct(Main $main, Event $event) {
            parent::__construct($main);
            $event->setCurrentUser($this->user)
                  ->setCurrentPlanet($this->planet);

            $this->event            = $event;
            $this->currentBuildJobs = $this->main->getBuildingsEvents();
        }

        public function getIndex() {
            $buildings = $this->setBuildingValues();

            return view('pages.game.'.$this->game['viewpath'].'.buildings')->with([
                'current_build_jobs' => $this->currentBuildJobs,
                'buildings'          => $buildings
            ]);
        }

        public function getStart($building) {
            $buildings = $this->setBuildingValues();
            if(isset($buildings[$building])) {
                if($this->event->add($buildings[$building], 1)) {
                    return redirect('buildings');
                }

                return redirect('buildings');
            }

            return redirect('buildings');
        }

        public function getCancel($eventId) {
            $event = $this->event->find($eventId);
            if(!is_null($event)) {
                if($event->user_id == $this->user->id && $event->type == 1 && $event->planet_id == $this->planet->id) {
                    if($this->event->cancel($event)) {
                        return redirect('buildings');
                    }

                    return redirect('buildings');
                }

                return redirect('buildings');
            }

            return redirect('buildings');
        }

        private function setBuildingValues() {
            $buildings = require_once(base_path().'/resources/data/buildings.php');

            $this->currentBuildJobs->map(function($job) use (&$buildings) {
                $data = unserialize($job->data);
                $buildings[$data['key']]['level']++;
            });

            foreach($buildings as $build => $building) {
                foreach($building['needs'] as $current => $required) {
                    if($current < $required) {
                        unset($buildings[$build]);
                        continue(2);
                    }
                }

                $building = $this->setResources($building);
                $building = $this->setBuildTime($building);

                if(isset($building['production'])) {
                    $building = $this->setProduction($building);
                }

                if(isset($building['capacity'])) {
                    $building = $this->setCapacity($building);
                }

                // Check if the build queue is full
                if($this->currentBuildJobs->count() < 5) {
                    $building = $this->setBuildPermission($building);
                } else {
                    $building['build'] = false;
                }

                $building          = $this->setResourceTime($building);
                $buildings[$build] = $building;
            }

            return $buildings;
        }

        private function setResources($building) {
            $building['aluminium'] = floor($building['aluminium'] * pow(($this->planet->buildings->{$building['key']} + ($building['level'] + 1)), 1.65));
            $building['titan']     = floor($building['titan'] * pow(($this->planet->buildings->{$building['key']} + ($building['level'] + 1)), 1.65));
            $building['silizium']  = floor($building['silizium'] * pow(($this->planet->buildings->{$building['key']} + ($building['level'] + 1)), 1.65));

            return $building;
        }

        private function setProduction($building) {
            $building['production'] = floor($building['production'][0] * pow(($this->planet->buildings->{$building['key']} + ($building['level'] + 1)), $building['production'][1]) * $this->game['speed']);
            return $building;
        }

        private function setCapacity($building) {
            $building['capacity'] = floor($building['capacity'][0] + pow(($this->planet->buildings->{$building['key']} + ($building['level'] + 1)), 2) * $building['capacity'][1]);
            return $building;
        }

        private function setBuildTime($building) {
            $modifier = $building['key'] == 'kommandozentrale' ? 1 + ($this->research->mikroarchitektur * 0.1) : 1;

            $building['time'] = floor(((($building['aluminium'] + $building['titan']) / (2500 * (1 + $this->planet->buildings->kommandozentrale) * $modifier)) * 3600) / $this->game['speed']);
            return $building;
        }

        private function setBuildPermission($building) {
            $building['build'] = $building['aluminium'] <= $this->resources->aluminium &&
                                 $building['titan'] <= $this->resources->titan &&
                                 $building['silizium'] <= $this->resources->silizium ? true : false;

            return $building;
        }

        private function setResourceTime($building) {
            $data = [
                floor(($building['aluminium'] - $this->resources->aluminium) / ($this->production->aluminium + $this->game['aluminium'])),
                floor(($building['titan'] - $this->resources->titan) / ($this->production->titan + $this->game['titan'])),
                floor(($building['silizium'] - $this->resources->silizium) / ($this->production->silizium + $this->game['silizium']))
            ];

            $building['restime'] = max($data);
            return $building;
        }

    }