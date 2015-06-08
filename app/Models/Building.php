<?php
    namespace Eternal\Models;

    class Building extends Base {

        public $timestamps = false;
        protected $table   = 'planets_buildings';

        public function add(Planet $planet) {
            $this->planet_id = $planet->id;

            return $this->save();
        }

    }