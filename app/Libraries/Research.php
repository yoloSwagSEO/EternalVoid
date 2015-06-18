<?php
    namespace Eternal\Libraries;

    use Carbon\Carbon;
    use Eternal\Models\Event;

    class Research {

        private $event;
        private $events;
        private $research;

        public function __construct(Event $event) {
            $this->event = $event;
        }

        public function handleEvents(Resources $libResources) {
            $this->events = $this->event->read($this->research->user_id, 2);
            foreach($this->events as $event) {
                $data = unserialize($event->data);

                if(Carbon::now()->gte($event->finished_at)) {
                    $this->research->{$data['key']}++;
                    $this->research->pkt++;
                    $this->research->save();

                    if($data['key'] == 'geologie' ||
                       $data['key'] == 'speziallegierungen' ||
                       $data['key'] == 'materiestabilisierung'
                    ) {
                        $libResources->pushToStack($event, $data);
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

        public function setResearch($research) {
            $this->research = $research;
            return $this;
        }

        public function getEvents() {
            return $this->events;
        }
    }