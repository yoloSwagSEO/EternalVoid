<?php
    namespace Eternal\Models;

    /**
     * Class Building
     * @package Eternal\Models
     *
     * @property int $planet_id
     * @property int $aluminiummine
     * @property int $titanfertigung
     * @property int $siliziummine
     * @property int $arsenfertigung
     * @property int $wasserstofffabrik
     * @property int $antimateriefabrik
     * @property int $lager
     * @property int $speziallager
     * @property int $tanks
     * @property int $bunker
     * @property int $schiffswerft
     * @property int $raumhafen
     * @property int $sternenbasis
     * @property int $flottenkommando
     * @property int $planetarer_schild
     * @property int $kommandozentrale
     * @property int $forschungszentrum
     * @property int $handelsboerse
     * @property int $schiffsboerse
     */

    class Building extends Base {

        public $timestamps = false;
        protected $table   = 'planets_buildings';

        public function add(Planet $planet) {
            $this->planet_id = $planet->id;

            return $this->save();
        }

    }