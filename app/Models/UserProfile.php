<?php
    namespace Eternal\Models;

    use Request;

    /**
     * Class UserProfile
     * @package Eternal\Models
     *
     * @property int $user_id
     * @property int $race_id
     * @property int $alliance_id
     * @property int $alliance_rank_id
     * @property int $planetimages
     */

    class UserProfile extends Base {

        public $timestamps = false;
        protected $table   = 'users_profiles';

        public function add($user) {
            $this->user_id 			= $user->id;
            $this->race_id 			= Request::get('race');
            $this->alliance_id 		= 0;
            $this->alliance_rank_id = 0;
            $this->planetimages 	= true;

            return $this->save();
        }

        public function setPlanetimages(UserProfile $userProfile) {
            $userProfile->planetimages = $userProfile->planetimages ? false : true;
            return $userProfile->save();
        }

        public function setAlliance($allianceId, UserProfile $userProfile) {
            $userProfile->alliance_id = $allianceId;
            return $userProfile->save();
        }

        public function setAllianceRank($allianceRankId, UserProfile $userProfile) {
            $userProfile->alliance_rank_id = $allianceRankId;
            return $userProfile->save();
        }

        public function race() {
            return $this->belongsTo('Eternal\Models\Race', 'race_id', 'id');
        }

        public function alliance() {
            return $this->belongsTo('Eternal\Models\Alliance', 'alliance_id', 'id');
        }

        public function alliancePermissions() {
            return $this->hasOne('Eternal\Models\AllianceRank', 'id', 'alliance_rank_id');
        }

    }