<?php
	namespace Eternal\Models;

	use Illuminate\Database\Eloquent\Model as Eloquent;

	use Validator;
	use Request;

	class Base extends Eloquent {

		public $validator;

		public function isValid($rules = [], $messages = []) {
			$this->validator = Validator::make(Request::all(), $rules, $messages);
			return $this->validator->passes();
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