<?php
	namespace Eternal\Models;

	use Request;
	use Crypt;
	use Auth;

	class User extends Base {

		protected $table = 'users';

		public function login() {
			$rules = [
				'username' => 'required',
				'password' => 'required',
			];

			$messages = [
				'username.required' => trans('users.messages.login_username_required'),
				'password.required' => trans('users.messages.login_password_required'),
				'disabled'          => trans('users.messages.login_disabled_account'),
				'loginfailed'       => trans('users.messages.login_incorrect_login'),
			];

			if($this->isValid($rules, $messages)) {
				$credentials = [
					'username' => Request::get('username'),
					'password' => Request::get('password'),
				];

				if(Auth::attempt($credentials, Request::exists('remember'))) {
					if(!is_null(Auth::user()->disabled_at)) {
						return true;
					}

					$this->validator->messages()->add('disabled', $messages['disabled']);
					$this->logout();

					return false;
				}

				$this->validator->messages()->add('loginfailed', $messages['loginfailed']);
				return false;
			}

			return false;
		}

		public function logout() {

		}

		public function register() {

		}

		public function add() {

		}

		public function modify() {

		}

		public function remove() {

		}

		public function planets() {
			return $this->hasMany('Eternal\Models\Planets', 'user_id', 'id');
		}

		public function profile() {
			return $this->hasOne('Eternal\Models\Profile', 'user_id', 'id');
		}
	}