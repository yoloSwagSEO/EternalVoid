<?php
    namespace Eternal\Http\Controllers;

    use Eternal\Libraries\Main;
    use Eternal\Models\AllianceApplication;

    class AlliancesApplicationsController extends MainController {

        private $allianceApplication;

        public function __construct(Main $main, AllianceApplication $allianceApplication) {
            parent::__construct($main);

            $this->allianceApplication = $allianceApplication;
        }

    }