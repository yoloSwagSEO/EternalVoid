<?php
    namespace Eternal\Models;

    /**
     * Class Resource
     * @package Eternal\Models
     *
     * @property int $planet_id
     * @property float $aluminium
     * @property float $titan
     * @property float $silizium
     * @property float $arsen
     * @property float $wasserstoff
     * @property float $antimaterie
     * @property int $lager_cap
     * @property int $speziallager_cap
     * @property int $tanks_cap
     * @property int $bunker_cap
     * @property float $lager_int
     * @property float $speziallager_int
     * @property float $tanks_int
     * @property float $bunker_int
     */

    class Resource extends Base {

        public $timestamps = false;
        protected $table   = 'planets_resources';

        public function add(Planet $planet) {
            $this->planet_id = $planet->id;

            return $this->save();
        }

    }