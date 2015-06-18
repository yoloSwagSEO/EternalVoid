<?php
    namespace Eternal\Models;

    /**
     * Class Production
     * @package Eternal\Models
     *
     * @property int $planet_id
     * @property float $aluminium
     * @property float $titan
     * @property float $silizium
     * @property float $arsen
     * @property float $wasserstoff
     * @property float $antimaterie
     */

    class Production extends Base {

        public $timestamps = false;
        protected $table   = 'planets_production';

        public function add(Planet $planet) {
            $this->planet_id = $planet->id;

            return $this->save();
        }

    }