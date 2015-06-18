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

        private function setProduction($data) {
            switch($data['key']) {
                case 'aluminiummine':
                case 'titanfertigung':
                case 'siliziummine':
                case 'arsenfertigung':
                case 'wasserstofffabrik':
                case 'antimateriefabrik':
                    $production = $data['production'] / 3600;
                    if($data['key'] == 'aluminiummine') $this->planet->production->aluminium = $production * $this->getGeologieBonus();
                    if($data['key'] == 'titanfertigung') $this->planet->production->titan = $production * $this->getSpeziallegierungBonus();
                    if($data['key'] == 'siliziummine') $this->planet->production->silizium = $production * $this->getGeologieBonus();
                    if($data['key'] == 'arsenfertigung') $this->planet->production->arsen = $production  * $this->getSpeziallegierungBonus();
                    if($data['key'] == 'wasserstofffabrik') $this->planet->production->wasserstoff = $production * $this->getMateriestabilisierungBonus();
                    if($data['key'] == 'antimateriefabrik') $this->planet->production->antimaterie = $production * $this->getMateriestabilisierungBonus();
                break;
                case 'geologie':
                    $this->planet->production->aluminium = $this->planet->production->aluminium * $this->getGeologieBonus();
                    $this->planet->production->silizium  = $this->planet->production->silizium * $this->getGeologieBonus();
                break;
                case 'speziallegierung':
                    $this->planet->production->titan = $this->planet->production->titan * $this->getSpeziallegierungBonus();
                    $this->planet->production->arsen = $this->planet->production->arsen * $this->getSpeziallegierungBonus();
                case 'materiestabilisierung':
                    $this->planet->production->wasserstoff = $this->planet->production->wasserstoff * $this->getMateriestabilisierungBonus();
                    $this->planet->production->antimaterie = $this->planet->production->antimaterie * $this->getMateriestabilisierungBonus();
                break;
            }
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

        private function setAluminiumProduction($production) {
            if($this->planet->resources->lager_int < 100) {
                $this->planet->resources->aluminium += ($production->aluminium + $this->game['aluminium']) * $this->interval;
            }

            return $this;
        }

        private function setTitanProduction($production) {
            if($this->planet->resources->lager_int < 100) {
                $this->planet->resources->titan += ($production->titan + $this->game['titan']) * $this->interval;
            }

            return $this;
        }

        private function setSiliziumProduction($production) {
            if($this->planet->resources->lager_int < 100) {
                $this->planet->resources->silizium += ($production->silizium + $this->game['silizium']) * $this->interval;
            }

            return $this;
        }

        private function setArsenProduction($production) {
            if($this->planet->resources->speziallager_int < 100) {
                $this->planet->resources->arsen += $production->arsen * $this->interval;
            }

            return $this;
        }

        private function setWasserstoffProduction($production) {
            if($this->planet->resources->speziallager_int < 100) {
                $this->planet->resources->wasserstoff += $production->wasserstoff * $this->interval;
            }

            return $this;
        }

        private function setAntimaterieProduction($production) {
            if($this->planet->resources->tanks_int < 100) {
                $this->planet->resources->antimaterie += $production->antimaterie * $this->interval;
            }

            return $this;
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

                $this->setAluminiumProduction($item['production'])
                     ->setTitanProduction($item['production'])
                     ->setSiliziumProduction($item['production'])
                     ->setArsenProduction($item['production'])
                     ->setWasserstoffProduction($item['production'])
                     ->setAntimaterieProduction($item['production']);

                $this->planet->resources->bunker_int = (($this->planet->resources->aluminium + $this->planet->resources->titan + $this->planet->resources->silizium + $this->planet->resources->arsen + $this->planet->resources->wasserstoff + $this->planet->resources->antimaterie) / $this->planet->resources->bunker_cap) * 100;
                $this->planet->resources->bunker_int = $this->planet->resources->bunker_int > 100 ? 100 : $this->planet->resources->bunker_int;

                $this->overflow($item['production']);
            }
        }

        public function overflow($production) {
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