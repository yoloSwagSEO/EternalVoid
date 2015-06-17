<?php
    namespace Eternal\Models;

    /**
     * Class Resource
     * @package Eternal\Models
     *
     * @property int $planet_id
     */

    class Resource extends Base {

        public $timestamps = false;
        protected $table   = 'planets_resources';

        public function add(Planet $planet) {
            $this->planet_id = $planet->id;

            return $this->save();
        }

    }