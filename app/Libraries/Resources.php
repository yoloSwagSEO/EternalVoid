<?php
    namespace Eternal\Libraries;

    class Resources {

        private $game;
        private $planet;
        private $research;
        private $interval;

        private $geologieBonus;
        private $speziallegierungBonus;
        private $materiestabilisierungBonus;

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

        private function setGeologieBonus() {
            $this->geologieBonus = 1 + (($this->planet->bonus + ($this->research->geologie * 5)) / 100);
            return $this;
        }

        private function setSpeziallegierungBonus() {
            $this->speziallegierungBonus = 1 + (($this->planet->bonus + ($this->research->speziallegierungen * 5)) / 100);
            return $this;
        }

        private function setMateriestabilisierungBonus() {
            $this->materiestabilisierungBonus = 1 + (($this->planet->bonus + ($this->research->materiestabilisierung * 5)) / 100);
            return $this;
        }

        private function setAluminiumProduction() {
            $this->planet->resources->aluminium += (($this->planet->production->aluminium * $this->geologieBonus) + $this->game['aluminium']) * $this->interval;
            return $this;
        }

        private function setTitanProduction() {
            $this->planet->resources->titan += (($this->planet->production->titan * $this->speziallegierungBonus) + $this->game['titan']) * $this->interval;
            return $this;
        }

        private function setSiliziumProduction() {
            $this->planet->resources->silizium += (($this->planet->production->silizium * $this->geologieBonus) + $this->game['silizium']) * $this->interval;
            return $this;
        }

        private function setArsenProduction() {
            $this->planet->resources->arsen += ($this->planet->production->arsen * $this->speziallegierungBonus) * $this->interval;
            return $this;
        }

        private function setWasserstoffProduction() {
            $this->planet->resources->wasserstoff += ($this->planet->production->wasserstoff * $this->materiestabilisierungBonus) * $this->interval;
            return $this;
        }

        private function setAntimaterieProduction() {
            $this->planet->resources->antimaterie += ($this->planet->production->antimaterie * $this->materiestabilisierungBonus) * $this->interval;
            return $this;
        }

        public function process($interval) {
            $this->interval = $interval;

            $this->setGeologieBonus()
                ->setSpeziallegierungBonus()
                ->setMateriestabilisierungBonus();

            if($this->planet->resources->lager_int < 100) {
                $this->setAluminiumProduction()
                    ->setTitanProduction()
                    ->setSiliziumProduction();
            }

            if($this->planet->resources->speziallager_int < 100) {
                $this->setArsenProduction()
                    ->setWasserstoffProduction();
            }

            if($this->planet->resources->tanks_int < 100) {
                $this->setAntimaterieProduction();
            }

            if($this->planet->resources->bunker_int < 100) {
                $this->planet->resources->bunker_int = (($this->planet->resources->aluminium + $this->planet->resources->titan + $this->planet->resources->silizium + $this->planet->resources->arsen + $this->planet->resources->wasserstoff + $this->planet->resources->antimaterie) / $this->planet->resources->bunker_cap) * 100;
                $this->planet->resources->bunker_int = $this->planet->resources->bunker_int > 100 ? 100 : $this->planet->resources->bunker_int;
            } else {
                $this->planet->resources->bunker_int = 100;
            }

            $this->overflow();
        }

        public function overflow() {
            $lager_resources        = $this->planet->resources->aluminium + $this->planet->resources->titan + $this->planet->resources->silizium;
            $speziallager_resources = $this->planet->resources->wasserstoff + $this->planet->resources->arsen;

            if($lager_resources >= $this->planet->resources->lager_cap) {
                $aluminium_production = ($this->planet->production->aluminium * $this->geologieBonus) + $this->game['aluminium'];
                $titan_production 	  = ($this->planet->production->titan * $this->speziallegierungBonus) + $this->game['titan'];
                $silizium_production  = ($this->planet->production->silizium * $this->geologieBonus) + $this->game['silizium'];

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
                $arsen_production 		= $this->planet->production->arsen * $this->speziallegierungBonus;
                $wasserstoff_production = $this->planet->production->wasserstoff * $this->materiestabilisierungBonus;

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