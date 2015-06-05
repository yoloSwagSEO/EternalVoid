<?php
	namespace Eternal\Http\Controllers;

	use Eternal\Libraries\Main;

	class ResourcesController extends MainController {

		public function __construct(Main $main) {
			parent::__construct($main);
		}

		public function getIndex() {
			$aluminium_bonus_production   = $this->production->aluminium * (($this->planet->bonus + ($this->research->geologie * 5)) / 100);
			$aluminium_all_production     = $this->production->aluminium + $aluminium_bonus_production + $this->game['aluminium'];
			$titan_bonus_production       = $this->production->titan * (($this->planet->bonus + ($this->research->speziallegierungen * 5)) / 100);
			$titan_all_production         = $this->production->titan + $titan_bonus_production + $this->game['titan'];
			$silizium_bonus_production    = $this->production->silizium * (($this->planet->bonus + ($this->research->geologie * 5)) / 100);
			$silizium_all_production      = $this->production->silizium + $silizium_bonus_production + $this->game['silizium'];
			$arsen_bonus_production       = $this->production->arsen * (($this->planet->bonus + ($this->research->speziallegierungen * 5)) / 100);
			$arsen_all_production         = $this->production->arsen + $arsen_bonus_production;
			$wasserstoff_bonus_production = $this->production->wasserstoff * (($this->planet->bonus + ($this->research->materiestabilisierung * 5)) / 100);
			$wasserstoff_all_production   = $this->production->wasserstoff + $wasserstoff_bonus_production;
			$antimaterie_bonus_production = $this->production->antimaterie * (($this->planet->bonus + ($this->research->materiestabilisierung * 5)) / 100);
			$antimaterie_all_production   = $this->production->antimaterie + $antimaterie_bonus_production;

			$ltime = round(($this->resources->lager_cap - ($this->resources->aluminium + $this->resources->titan + $this->resources->silizium)) / ($aluminium_all_production + $titan_all_production + $silizium_all_production));
			$stime = $this->production->wasserstoff > 0 || $this->production->arsen > 0 ? round(($this->resources->speziallager_cap - ($this->resources->arsen + $this->resources->wasserstoff)) / ($arsen_all_production + $wasserstoff_all_production)) : 0;
			$ttime = $this->production->antimaterie > 0 ? round(($this->resources->tanks_cap - $this->resources->antimaterie) / $antimaterie_all_production) : 0;

			$data = [
				'ltime'                              => $ltime,
				'stime'                              => $stime,
				'ttime'                              => $ttime,

				'aluminium_bonus'                    => $this->planet->bonus + ($this->research->geologie * 5),
				'aluminium_base_production_min'      => $this->helper->nf($this->game['aluminium'] * 60, 2),
				'aluminium_mine_production_min'      => $this->helper->nf($this->production->aluminium * 60, 2),
				'aluminium_bonus_production_min'     => $this->helper->nf($aluminium_bonus_production * 60, 2),
				'aluminium_all_production_min'       => $this->helper->nf($aluminium_all_production * 60, 2),
				'aluminium_base_production_hour'     => $this->helper->nf($this->game['aluminium'] * 3600),
				'aluminium_mine_production_hour'     => $this->helper->nf($this->production->aluminium * 3600),
				'aluminium_bonus_production_hour'    => $this->helper->nf($aluminium_bonus_production * 3600),
				'aluminium_all_production_hour'      => $this->helper->nf($aluminium_all_production * 3600),
				'aluminium_base_production_daily'    => $this->helper->nf($this->game['aluminium'] * 86400),
				'aluminium_mine_production_daily'    => $this->helper->nf($this->production->aluminium * 86400),
				'aluminium_bonus_production_daily'   => $this->helper->nf($aluminium_bonus_production * 86400),
				'aluminium_all_production_daily'     => $this->helper->nf($aluminium_all_production * 86400),

				'titan_bonus'                        => $this->planet->bonus + ($this->research->speziallegierungen * 5),
				'titan_base_production_min'          => $this->helper->nf($this->game['titan'] * 60, 2),
				'titan_mine_production_min'          => $this->helper->nf($this->production->titan * 60, 2),
				'titan_bonus_production_min'         => $this->helper->nf($titan_bonus_production * 60, 2),
				'titan_all_production_min'           => $this->helper->nf($titan_all_production * 60, 2),
				'titan_base_production_hour'         => $this->helper->nf($this->game['titan'] * 3600),
				'titan_mine_production_hour'         => $this->helper->nf($this->production->titan * 3600),
				'titan_bonus_production_hour'        => $this->helper->nf($titan_bonus_production * 3600),
				'titan_all_production_hour'          => $this->helper->nf($titan_all_production * 3600),
				'titan_base_production_daily'        => $this->helper->nf($this->game['titan'] * 86400),
				'titan_mine_production_daily'        => $this->helper->nf($this->production->titan * 86400),
				'titan_bonus_production_daily'       => $this->helper->nf($titan_bonus_production * 86400),
				'titan_all_production_daily'         => $this->helper->nf($titan_all_production * 86400),

				'silizium_bonus'                     => $this->planet->bonus + ($this->research->geologie * 5),
				'silizium_base_production_min'       => $this->helper->nf($this->game['silizium'] * 60, 2),
				'silizium_mine_production_min'       => $this->helper->nf($this->production->silizium * 60, 2),
				'silizium_bonus_production_min'      => $this->helper->nf($silizium_bonus_production * 60, 2),
				'silizium_all_production_min'        => $this->helper->nf($silizium_all_production * 60, 2),
				'silizium_base_production_hour'      => $this->helper->nf($this->game['silizium'] * 3600),
				'silizium_mine_production_hour'      => $this->helper->nf($this->production->silizium * 3600),
				'silizium_bonus_production_hour'     => $this->helper->nf($silizium_bonus_production * 3600),
				'silizium_all_production_hour'       => $this->helper->nf($silizium_all_production * 3600),
				'silizium_base_production_daily'     => $this->helper->nf($this->game['silizium'] * 86400),
				'silizium_mine_production_daily'     => $this->helper->nf($this->production->silizium * 86400),
				'silizium_bonus_production_daily'    => $this->helper->nf($silizium_bonus_production * 86400),
				'silizium_all_production_daily'      => $this->helper->nf($silizium_all_production * 86400),

				'arsen_bonus'                        => $this->planet->bonus + ($this->research->speziallegierungen * 5),
				'arsen_mine_production_min'          => $this->helper->nf($this->production->arsen * 60, 2),
				'arsen_bonus_production_min'         => $this->helper->nf($arsen_bonus_production * 60, 2),
				'arsen_all_production_min'           => $this->helper->nf($arsen_all_production * 60, 2),
				'arsen_mine_production_hour'         => $this->helper->nf($this->production->arsen * 3600),
				'arsen_bonus_production_hour'        => $this->helper->nf($arsen_bonus_production * 3600),
				'arsen_all_production_hour'          => $this->helper->nf($arsen_all_production * 3600),
				'arsen_mine_production_daily'        => $this->helper->nf($this->production->arsen * 86400),
				'arsen_bonus_production_daily'       => $this->helper->nf($arsen_bonus_production * 86400),
				'arsen_all_production_daily'         => $this->helper->nf($arsen_all_production * 86400),

				'wasserstoff_bonus'                  => $this->planet->bonus + ($this->research->materiestabilisierung * 5),
				'wasserstoff_mine_production_min'    => $this->helper->nf($this->production->wasserstoff * 60, 2),
				'wasserstoff_bonus_production_min'   => $this->helper->nf($wasserstoff_bonus_production * 60, 2),
				'wasserstoff_all_production_min'     => $this->helper->nf($wasserstoff_all_production * 60, 2),
				'wasserstoff_mine_production_hour'   => $this->helper->nf($this->production->wasserstoff * 3600),
				'wasserstoff_bonus_production_hour'  => $this->helper->nf($wasserstoff_bonus_production * 3600),
				'wasserstoff_all_production_hour'    => $this->helper->nf($wasserstoff_all_production * 3600),
				'wasserstoff_mine_production_daily'  => $this->helper->nf($this->production->wasserstoff * 86400),
				'wasserstoff_bonus_production_daily' => $this->helper->nf($wasserstoff_bonus_production * 86400),
				'wasserstoff_all_production_daily'   => $this->helper->nf($wasserstoff_all_production * 86400),

				'antimaterie_bonus'                  => $this->planet->bonus + ($this->research->materiestabilisierung * 5),
				'antimaterie_mine_production_min'    => $this->helper->nf($this->production->antimaterie * 60, 2),
				'antimaterie_bonus_production_min'   => $this->helper->nf($antimaterie_bonus_production * 60, 2),
				'antimaterie_all_production_min'     => $this->helper->nf($antimaterie_all_production * 60, 2),
				'antimaterie_mine_production_hour'   => $this->helper->nf($this->production->antimaterie * 3600),
				'antimaterie_bonus_production_hour'  => $this->helper->nf($antimaterie_bonus_production * 3600),
				'antimaterie_all_production_hour'    => $this->helper->nf($antimaterie_all_production * 3600),
				'antimaterie_mine_production_daily'  => $this->helper->nf($this->production->antimaterie * 86400),
				'antimaterie_bonus_production_daily' => $this->helper->nf($antimaterie_bonus_production * 86400),
				'antimaterie_all_production_daily'   => $this->helper->nf($antimaterie_all_production * 86400),
			];

			$buildings = $this->planet->buildings;

			return view('pages.game.'.$this->game['viewpath'].'.resources', $data)->with([
				'buildings' => $buildings
			]);
		}

	}