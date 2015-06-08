<?php
    namespace Eternal\Models;

    class Defense extends Base {

        public $timestamps = false;
        protected $table   = 'planets_defenses';

        public function add(Planet $planet) {
            $this->planet_id = $planet->id;

            return $this->save();
        }

    }