<?php
	namespace Eternal\Models;

	use Illuminate\Database\Eloquent\Model;

	use Validator;
	use Request;

	class Base extends Model {

		/* @var $validator \Illuminate\Validation\Validator */
		public $validator;

		protected $usr;
		protected $plt;

		public function isValid($rules = [], $messages = []) {
			$this->validator = Validator::make(Request::all(), $rules, $messages);
			return $this->validator->passes();
		}

		public function setCurrentUser(User $user) {
			$this->usr = $user;

			return $this;
		}

		public function setCurrentPlanet(Planet $planet) {
			$this->plt = $planet;

			return $this;
		}

		protected function creator() {
			return $this->hasOne('Eternal\Models\User', 'created_uid', 'id');
		}

		protected function modifier() {
			return $this->hasOne('Eternal\Models\User', 'modified_uid', 'id');
		}

		protected function remover() {
			return $this->hasOne('Eternal\Models\User', 'deleted_uid', 'id');
		}

	}