<?php
    namespace Eternal\Models;

    /**
     * Class Research
     * @package Eternal\Models
     *
     * @property int $user_id
     * @property int $pkt
     * @property int $pulsantrieb
     * @property int $antimaterieantrieb
     * @property int $projektilwaffen
     * @property int $laserwaffen
     * @property int $plasmawaffen
     * @property int $phasenwaffen
     * @property int $strukturelle_integritaet
     * @property int $mikroarchitektur
     * @property int $orbitalkonstruktion
     * @property int $lagererweiterung
     * @property int $schiffskapazitaet
     * @property int $rumpfstatik
     * @property int $werftarchitektur
     * @property int $schildtechnologie
     * @property int $kommunikation
     * @property int $imperiale_verwaltung
     * @property int $spionage
     * @property int $recycling
     * @property int $geologie
     * @property int $speziallegierungen
     * @property int $materiestabilisierung
     */

    class Research extends Base {

        public $timestamps = false;
        protected $table   = 'users_research';

        public function add(User $user) {
            $this->user_id = $user->id;

            return $this->save();
        }

    }