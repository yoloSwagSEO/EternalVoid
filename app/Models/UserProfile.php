<?php
    namespace Eternal\Models;

    use Request;

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

        public function race() {
            return $this->belongsTo('Eternal\Models\Race', 'race_id', 'id');
        }

        public function alliance() {
            return $this->belongsTo('Eternal\Models\Alliance', 'alliance_id', 'id');
        }

    }