<?php
    namespace Eternal\Http\Controllers;

    use Eternal\Libraries\Main;
    use Eternal\Models\AllianceMessage;

    class AlliancesMessagesController extends MainController {

        private $allianceMessage;

        public function __construct(Main $main, AllianceMessage $allianceMessage) {
            $this->allianceMessage = $allianceMessage;
        }

    }