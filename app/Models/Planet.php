<?php
	namespace Eternal\Models;

	use Crypt;
	use DB;

	class Planet extends Base {

		protected $table = 'planets';

		public function read($id = '', $userId = '', $with = []) {
			if(!empty($id)) {
				return $this->with($with)->find($id);
			}

			if(!empty($userId)) {
				return $this->with($with)->whereUserId($userId)->whereBaseId(session('baseId', 1))->get()->first();
			}

			return $this->with($with)->get();
		}

		public function random() {
			return $this->whereBonus(0)->whereUserId(0)->orderBy(DB::raw('RAND()'))->take(1)->first();
		}

		public function setUser(Planet $planet, User $user) {
			$planet->user_id       = $user->id;
			$planet->base_id       = 1;
			$planet->planetname    = Crypt::encrypt('Planet');
			$planet->settled_at    = (new \DateTime())->format('Y-m-d H:i:s');
			$planet->lastupdate_at = time();

			return $planet->save();
		}

		public function setLastupdate(Planet $planet) {
			$planet->lastupdate_at = time();
			return $planet->save();
		}

		public function production() {
			return $this->hasOne('Eternal\Models\Production', 'planet_id', 'id');
		}

		public function resources() {
			return $this->hasOne('Eternal\Models\Resource', 'planet_id', 'id');
		}

		public function buildings() {
			return $this->hasOne('Eternal\Models\Building', 'planet_id', 'id');
		}

		public function defenses() {
			return $this->hasOne('Eternal\Models\Defense', 'planet_id', 'id');
		}

		public function units() {
			return $this->hasOne('Eternal\Models\Unit', 'planet_id', 'id');
		}

	}