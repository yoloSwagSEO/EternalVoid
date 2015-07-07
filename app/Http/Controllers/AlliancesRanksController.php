<?php
    namespace Eternal\Http\Controllers;

    use Eternal\Libraries\Main;
    use Eternal\Models\AllianceRank;

    class AlliancesRanksController extends MainController {

        private $allianceRank;

        public function __construct(Main $main, AllianceRank $allianceRank) {
            parent::__construct($main);

            $this->allianceRank = $allianceRank;
        }

    }