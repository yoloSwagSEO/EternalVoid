<?php
	namespace Eternal\Models;

	use Crypt;
	use DB;
	use Carbon\Carbon;

	class Planet extends Base {

		protected $table = 'planets';
		protected $dates = [
			'lastupdate_at'
		];

		public function read($id = '', $userId = '', $with = []) {
			if(!empty($id)) {
				return $this->with($with)->find($id);
			}

			if(!empty($userId)) {
				return $this->with($with)
							->where('user_id', '=', $userId)
							->where('base_id', '=', session('baseId', 1))
							->get()
							->first();
			}

			return $this->with($with)->get();
		}

		public function in($galaxy, $system, $with = []) {
			return $this->with($with)
						->where('galaxy', '=', $galaxy)
						->where('system', '=', $system)
						->get();
		}

		public function random() {
			return $this->where('bonus', '=', 0)
						->where('user_id', '=', 0)
						->orderBy(DB::raw('RAND()'))
						->take(1)
						->first();
		}

		public function setUser(Planet $planet, User $user) {
			$planet->user_id       = $user->id;
			$planet->base_id       = 1;
			$planet->planetname    = Crypt::encrypt('Planet');
			$planet->settled_at    = Carbon::now();
			$planet->lastupdate_at = time();

			return $planet->save();
		}

		public function setLastupdate(Planet $planet) {
			$planet->lastupdate_at = Carbon::now();
			return $planet->save();
		}

		public function user() {
			return $this->belongsTo('Eternal\Models\User', 'user_id', 'id');
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