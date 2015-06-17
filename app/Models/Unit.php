<?php
    namespace Eternal\Models;

    /**
     * Class Unit
     * @package Eternal\Models
     *
     * @property int $planet_id
     */

    class Unit extends Base {

        public $timestamps = false;
        protected $table   = 'planets_units';

        public function add($planet) {
            $this->planet_id = $planet->id;

            return $this->save();
        }

    }