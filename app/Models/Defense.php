<?php
    namespace Eternal\Models;

    /**
     * Class Defense
     * @package Eternal\Models
     *
     * @property int $planet_id
     */

    class Defense extends Base {

        public $timestamps = false;
        protected $table   = 'planets_defenses';

        public function add(Planet $planet) {
            $this->planet_id = $planet->id;

            return $this->save();
        }

    }