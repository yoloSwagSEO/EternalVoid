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

            $this->plt->resources->aluminium -= isset($data['aluminium']) ? $data['aluminium'] : $this->plt->resources->aluminium;
            $this->plt->resources->titan -= isset($data['titan']) ? $data['titan'] : $this->plt->resources->titan;
            $this->plt->resources->silizium -= isset($data['silizium']) ? $data['silizium'] : $this->plt->resources->silizium;
            $this->plt->resources->arsen -= isset($data['arsen']) ? $data['arsen'] : $this->plt->resources->silizium;
            $this->plt->resources->wasserstoff -= isset($data['wasserstoff']) ? $data['wasserstoff'] : $this->plt->resources->wasserstoff;
            $this->plt->resources->antimaterie -= isset($data['antimaterie']) ? $data['antimaterie'] : $this->plt->resources->antimaterie;
            $this->plt->resources->save();

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

    }