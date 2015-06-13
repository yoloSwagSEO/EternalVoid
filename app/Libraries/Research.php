<?php
    namespace Eternal\Libraries;

    use Carbon\Carbon;
    use Eternal\Models\Event;

    class Research {

        private $event;
        private $events;
        private $planet;
        private $research;
        private $stack;

        public function __construct(Event $event) {
            $this->event = $event;
        }

        public function handleEvents() {
            $this->events = $this->event->read($this->research->user_id, 2);
            foreach($this->events as $event) {
                $data = unserialize($event->data);

                if(Carbon::now()->gte($event->finished_at)) {
                    $this->research->{$data['key']}++;
                    $this->research->pkt++;
                    $this->research->save();

                    if($data['key'] == 'geologie' || $data['key'] == 'speziallegierungen' || $data['key'] == 'materiestabilisierung') {
                        if(end($this->stack) === false) {
                            $this->stack[] = [
                                'start'      => $this->planet->lastupdate,
                                'end'        => $event->finished,
                                'production' => $this->planet->production
                            ];

                            $this->stack[] = [
                                'start'      => $event->finished,
                                'end'        => 0,
                                'production' => $this->calculateNewProduction($data)
                            ];

                        } else {
                            $this->stack[key($this->stack)]['end'] = $event->finished_at;
                            $this->stack[] = [
                                'start'      => $event->finished,
                                'end'        => 0,
                                'production' => $this->calculateNewProduction($data)
                            ];
                        }
                    }

                    $event->delete();
                    $item = $this->events->shift();
                    unset($item);
                } else {
                    $data['remaining'] = Carbon::now()->diffInSeconds($event->finished_at);
                    $this->event->modify($event, $data);
                }
            }
        }

        private function calculateNewProduction($data) {

            if($data['key'] == 'geologie') {
                $this->planet->production->aluminium = $this->planet->production->aluminium * 1.05;
                $this->planet->production->silizium  = $this->planet->production->silizium * 1.05;
            }

            if($data['key'] == 'speziallegierung') {
                $this->planet->production->titan = $this->planet->production->titan * 1.05;
                $this->planet->production->arsen = $this->planet->production->titan * 1.05;
            }

            if($data['key'] == 'materiestabilisierung') {
                $this->planet->production->wasserstoff = $this->planet->production->wasserstoff * 1.05;
                $this->planet->production->antimaterie = $this->planet->production->antimaterie * 1.05;
            }

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

        public function setResearch($research) {
            $this->research = $research;
            return $this;
        }

        public function getEvents() {
            return $this->events;
        }
    }