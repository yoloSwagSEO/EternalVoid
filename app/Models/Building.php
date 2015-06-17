<?php
    namespace Eternal\Models;

    /**
     * Class Building
     * @package Eternal\Models
     * @property-write int $planet_id
     */

    class Building extends Base {

        public $timestamps = false;
        protected $table   = 'planets_buildings';

        public function add(Planet $planet) {
            $this->planet_id = $planet->id;

            return $this->save();
        }

    }