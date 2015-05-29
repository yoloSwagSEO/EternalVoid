<?php
	namespace Eternal\Http\Controllers;

	use Eternal\Models\User;

	use Session;
	use Request;

	class UsersController extends Controller {

		private $user;

		public function __construct(User $user) {
			$this->user = $user;
		}

		public function getRegister() {
			return view('pages.users.register');
		}

		public function postRegister() {
			if($this->user->register()) {
				return redirect('users/register')->withSuccess(trans('users.messages.register_success'));
			}

			return redirect('users/register')->withErrors($this->user->validator)->withInput();
		}

		public function getLogin() {
			return view('pages.users.login');
		}

		public function postLogin() {
			if($this->user->login()) {
				return redirect('http://'.Session::get('universe').'.'.Request::getHttpHost().'/');
			}

			return redirect('earlyaccess')->withErrors($this->user->validator);
		}

		public function getLogout() {
			if($this->user->logout()) {
				return redirect('/')->withSuccess(trans('users.messages.logout_success'));
			}

			return redirect('/');
		}

	}