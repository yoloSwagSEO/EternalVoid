<?php
    namespace Eternal\Models;

    use Carbon\Carbon;

    class Event extends Base {

        protected $table = 'events';
        protected $dates = [
            'finished_at'
        ];

        public function read($userId, $type, $planetId = '') {
            if(!empty($planetId)) {
                return $this->where([
                    'user_id'   => $userId,
                    'planet_id' => $planetId,
                    'type'      => $type,
                ])->get();
            }

            return $this->where([
                'user_id' => $userId,
                'type'    => $type,
            ])->get();
        }

        public function add($data, $type) {
            unset($data['image']);
            unset($data['description']);
            unset($data['level']);
            unset($data['build']);
            unset($data['needs']);
            unset($data['restime']);

            // Needed for canel action
            $data['orig_time'] = $data['time'];

            $this->plt->resources->aluminium -= isset($data['aluminium']) ? $data['aluminium'] : 0;
            $this->plt->resources->titan -= isset($data['titan']) ? $data['titan'] : 0;
            $this->plt->resources->silizium -= isset($data['silizium']) ? $data['silizium'] : 0;
            $this->plt->resources->arsen -= isset($data['arsen']) ? $data['arsen'] : 0;
            $this->plt->resources->wasserstoff -= isset($data['wasserstoff']) ? $data['wasserstoff'] : 0;
            $this->plt->resources->antimaterie -= isset($data['antimaterie']) ? $data['antimaterie'] : 0;
            $this->plt->resources->save();

            $lastEvent = $this->last($this->usr->id, $type, $this->plt->id);
            if(!is_null($lastEvent)) {
                $lastEventData = unserialize($lastEvent->data);
                $data['time'] += $lastEventData['remaining'];
            }

            $this->user_id     = $this->usr->id;
            $this->planet_id   = $this->plt->id;
            $this->type        = $type;
            $this->finished_at = Carbon::now()->addSeconds($data['time']);
            $this->data        = serialize($data);

            return $this->save();
        }

        public function modify($event, $data) {
            $event->data = serialize($data);
            return $event->save();
        }

        public function remove($event) {
            return $event->delete();
        }

        public function cancel($event) {
            $events = $this->where([
                'user_id'   => $event->user_id,
                'planet_id' => $event->planet_id,
                'type'      => $event->type,
            ])->where(
                'id', '>', $event->id
            )->get();

            $eventData = unserialize($event->data);
            $remaining = $eventData['remaining'] / $eventData['time'];

            $this->plt->resources->aluminium += isset($eventData['aluminium']) ? $eventData['aluminium'] * $remaining : 0;
            $this->plt->resources->titan += isset($eventData['titan']) ? $eventData['titan'] * $remaining : 0;
            $this->plt->resources->silizium += isset($eventData['silizium']) ? $eventData['silizium'] * $remaining : 0;
            $this->plt->resources->arsen += isset($eventData['arsen']) ? $eventData['arsen'] * $remaining : 0;
            $this->plt->resources->wasserstoff += isset($eventData['wasserstoff']) ? $eventData['wasserstoff'] * $remaining : 0;
            $this->plt->resources->antimaterie += isset($eventData['antimaterie']) ? $eventData['antimaterie'] * $remaining : 0;
            $this->plt->resources->save();

            if(!$events->isEmpty()) {
                foreach($events as $key => $evt) {
                    $evtData = unserialize($evt->data);
                    $evtData['time'] -= $eventData['orig_time'];

                    $evt->data        = serialize($evtData);
                    $evt->finished_at = $evt->created_at->addSecond($evtData['time']);
                    $evt->save();
                }
            }

            return $this->remove($event);
        }

        private function last($userId, $type, $planetId = '') {
            return $this->where([
                'user_id'   => $userId,
                'planet_id' => $planetId,
                'type'      => $type,
            ])->orderBy('id', 'desc')
              ->take(1)
              ->get()
              ->first();
        }

    }