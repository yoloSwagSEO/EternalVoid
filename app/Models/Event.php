<?php
    namespace Eternal\Models;

    use Carbon\Carbon;

    /**
     * Class Event
     * @package Eternal\Models
     *
     * @property int $id
     * @property int $user_id
     * @property int $planet_id
     * @property int $type
     * @property mixed $created_at
     * @property mixed $finished_at
     * @property string $data
     */

    class Event extends Base {

        protected $table = 'events';
        protected $dates = [
            'finished_at'
        ];

        public function read($userId, $type, $planetId = '') {
            if(!empty($planetId)) {
                return $this->where('user_id', '=', $userId)
                            ->where('planet_id', '=', $planetId)
                            ->where('type', '=', $type)
                            ->get();
            }

            return $this->where('user_id', '=', $userId)
                        ->where('type', '=', $type)
                        ->get();
        }

        public function readById($eventId) {
            return $this->where('id', '=', $eventId)->get()->first();
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

            $this->plt->resources->aluminium -= $data['aluminium'];
            $this->plt->resources->titan -= $data['titan'];
            $this->plt->resources->silizium -= $data['silizium'];
            $this->plt->resources->arsen -= $data['arsen'];
            $this->plt->resources->wasserstoff -= $data['wasserstoff'];
            $this->plt->resources->antimaterie -= $data['antimaterie'];
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

        public function modify(Event $event, $data) {
            $event->data = serialize($data);
            return $event->save();
        }

        public function remove(Event $event) {
            return $event->delete();
        }

        public function cancel(Event $event) {
            $events = $this->where('user_id', '=', $event->user_id)
                           ->where('planet_id', '=', $event->planet_id)
                           ->where('type', '=', $event->type)
                           ->where('id', '>', $event->id)
                           ->get();

            $eventData = unserialize($event->data);
            $remaining = $eventData['remaining'] / $eventData['time'];

            $this->plt->resources->aluminium += $eventData['aluminium'] * $remaining;
            $this->plt->resources->titan += $eventData['titan'] * $remaining;
            $this->plt->resources->silizium += $eventData['silizium'] * $remaining;
            $this->plt->resources->arsen += $eventData['arsen'] * $remaining;
            $this->plt->resources->wasserstoff += $eventData['wasserstoff'] * $remaining;
            $this->plt->resources->antimaterie += $eventData['antimaterie'] * $remaining;
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
            return $this->where('user_id', '=', $userId)
                        ->where('planet_id', '=', $planetId)
                        ->where('type', '=', $type)
                        ->orderBy('id', 'desc')
                        ->take(1)
                        ->get()
                        ->first();
        }

    }