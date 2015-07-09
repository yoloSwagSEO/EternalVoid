<?php
    namespace Eternal\Libraries;

    use Carbon\Carbon;

    class Resources {

        private $game;
        private $planet;
        private $research;
        private $stack = [];

        private $interval;

        public function setGame($game) {
            $this->game = $game;

            return $this;
        }

        public function setPlanet($planet) {
            $this->planet = $planet;

            return $this;
        }

        public function setResearch($research) {
            $this->research = $research;

            return $this;
        }

        public function pushToStack($event, $data) {
            $lastItem    = end($this->stack);
            $lastItemKey = key($this->stack);

            if($lastItem === false) {
                $this->stack[] = [
                    'interval'   => $event->finished_at->diffInSeconds($this->planet->lastupdate_at),
                    'production' => $this->planet->production
                ];

                $this->setProduction($data);
                $this->stack[] = [
                    'interval'   => $event->finished_at,
                    'production' => $this->planet->production
                ];
            } else {
                $this->setProduction($data);
                $this->stack[$lastItemKey]['interval'] = $event->finished_at->diffInSeconds($this->stack[$lastItemKey]['interval']);
                $this->stack[] = [
                    'interval'   => $event->finished_at,
                    'production' => $this->planet->production
                ];
            }
        }

        public function process() {
            if(empty($this->stack)) {
                $this->stack[] = [
                    'interval'   => Carbon::now()->diffInSeconds($this->planet->lastupdate_at),
                    'production' => $this->planet->production
                ];
            }

            foreach($this->stack as $item) {
                $this->interval = is_object($item['interval']) ? Carbon::now()->diffInSeconds($item['interval']) : $item['interval'];

                $this->calculate($item['production']);

                $this->planet->resources->bunker_int = (($this->planet->resources->aluminium + $this->planet->resources->titan + $this->planet->resources->silizium + $this->planet->resources->arsen + $this->planet->resources->wasserstoff + $this->planet->resources->antimaterie) / $this->planet->resources->bunker_cap) * 100;
                $this->planet->resources->bunker_int = $this->planet->resources->bunker_int > 100 ? 100 : $this->planet->resources->bunker_int;

                $this->overflow($item['production']);
            }
        }

        private function setProduction($data) {
            switch($data['key']) {
                case 'aluminiummine':
                    $this->planet->production->aluminium = ($data['production'] / 3600) * $this->getGeologieBonus();
                break;
                case 'titanfertigung':
                    $this->planet->production->titan = ($data['production'] / 3600) * $this->getSpeziallegierungBonus();
                break;
                case 'siliziummine':
                    $this->planet->production->silizium = ($data['production'] / 3600) * $this->getGeologieBonus();
                break;
                case 'arsenfertigung':
                    $this->planet->production->arsen = ($data['production'] / 3600) * $this->getSpeziallegierungBonus();
                break;
                case 'wasserstofffabrik':
                    $this->planet->production->wasserstoff = ($data['production'] / 3600) * $this->getMateriestabilisierungBonus();
                break;
                case 'antimateriefabrik':
                    $this->planet->production->antimaterie = ($data['production'] / 3600) * $this->getMateriestabilisierungBonus();
                break;
            }

            $this->planet->production->aluminium = $this->planet->production->aluminium * $this->getGeologieBonus();
            $this->planet->production->titan = $this->planet->production->titan * $this->getSpeziallegierungBonus();
            $this->planet->production->silizium  = $this->planet->production->silizium * $this->getGeologieBonus();
            $this->planet->production->arsen = $this->planet->production->arsen * $this->getSpeziallegierungBonus();
            $this->planet->production->wasserstoff = $this->planet->production->wasserstoff * $this->getMateriestabilisierungBonus();
            $this->planet->production->antimaterie = $this->planet->production->antimaterie * $this->getMateriestabilisierungBonus();
        }

        private function getGeologieBonus() {
            return 1 + (($this->planet->bonus + ($this->research->geologie * 5)) / 100);
        }

        private function getSpeziallegierungBonus() {
            return 1 + (($this->planet->bonus + ($this->research->speziallegierungen * 5)) / 100);
        }

        private function getMateriestabilisierungBonus() {
            return 1 + (($this->planet->bonus + ($this->research->materiestabilisierung * 5)) / 100);
        }

        private function calculate($production) {
            if($this->planet->resources->lager_int < 100) {
                $this->planet->resources->aluminium += ($production->aluminium + $this->game['aluminium']) * $this->interval;
                $this->planet->resources->titan += ($production->titan + $this->game['titan']) * $this->interval;
                $this->planet->resources->silizium += ($production->silizium + $this->game['silizium']) * $this->interval;
            }

            if($this->planet->resources->speziallager_int < 100) {
                $this->planet->resources->arsen += $production->arsen * $this->interval;
                $this->planet->resources->wasserstoff += $production->wasserstoff * $this->interval;
            }

            if($this->planet->resources->tanks_int < 100) {
                $this->planet->resources->antimaterie += $production->antimaterie * $this->interval;
            }
        }

        private function overflow($production) {
            $lager_resources        = $this->planet->resources->aluminium + $this->planet->resources->titan + $this->planet->resources->silizium;
            $speziallager_resources = $this->planet->resources->wasserstoff + $this->planet->resources->arsen;

            if($lager_resources >= $this->planet->resources->lager_cap) {
                $aluminium_production = $production->aluminium + $this->game['aluminium'];
                $titan_production 	  = $production->titan + $this->game['titan'];
                $silizium_production  = $production->silizium + $this->game['silizium'];

                $div1    = $aluminium_production + $titan_production + $silizium_production;
                $faktor1 = $this->planet->resources->lager_cap / $div1;

                $this->planet->resources->aluminium = round($aluminium_production * $faktor1);
                $this->planet->resources->titan     = round($titan_production * $faktor1);
                $this->planet->resources->silizium  = round($silizium_production * $faktor1);
                $this->planet->resources->lager_int = 100;
            } else {
                $this->planet->resources->lager_int = ($lager_resources / $this->planet->resources->lager_cap) * 100;
            }

            if($speziallager_resources >= $this->planet->resources->speziallager_cap) {
                $arsen_production 		= $production->arsen;
                $wasserstoff_production = $production->wasserstoff;

                $div2    = $arsen_production + $wasserstoff_production;
                $faktor2 = $this->planet->resources->speziallager_cap / $div2;

                $this->planet->resources->wasserstoff      = round($wasserstoff_production * $faktor2);
                $this->planet->resources->arsen            = session('baseId', 1) != 1 ? round($arsen_production * $faktor2) : $this->planet->resources->arsen;
                $this->planet->resources->speziallager_int = 100;
            } else {
                $this->planet->resources->speziallager_int = ($speziallager_resources / $this->planet->resources->speziallager_cap) * 100;
            }

            if($this->planet->resources->antimaterie >= $this->planet->resources->tanks_cap) {
                $this->planet->resources->antimaterie = $this->planet->resources->tanks_cap;
                $this->planet->resources->tanks_int   = 100;
            } else {
                $this->planet->resources->tanks_int   = ($this->planet->resources->antimaterie / $this->planet->resources->tanks_cap) * 100;
            }
        }
    }