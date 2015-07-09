<?php
    namespace Eternal\Libraries;

    use Carbon\Carbon;
    use Eternal\Models\Event;

    class Buildings {

        private $event;
        private $events;
        private $planet;

        public function __construct(Event $event) {
            $this->event = $event;
        }

        public function handleEvents(Resources $libResources) {
            $this->events = $this->event->read($this->planet->user_id, 1, $this->planet->id);
            foreach($this->events as $event) {
                $data = unserialize($event->data);

                if(Carbon::now()->gte($event->finished_at)) {
                    $this->planet->buildings->{$data['key']}++;
                    $this->planet->buildings->save();
                    $this->planet->pkt++;
                    $this->planet->save();

                    if($data['production'] > 0) $libResources->pushToStack($event, $data);
                    if($data['capacity'] > 0) $this->planet->resources->{$data['key'].'_cap'} = $data['capacity'];

                    $this->event->remove($event);
                    $item = $this->events->shift();
                    unset($item);
                } else {
                    $data['remaining'] = Carbon::now()->diffInSeconds($event->finished_at);
                    $this->event->modify($event, $data);
                }
            }
        }

        public function setPlanet($planet) {
            $this->planet = $planet;
            return $this;
        }

        public function getEvents() {
            return $this->events;
        }
    }