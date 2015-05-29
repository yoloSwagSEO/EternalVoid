<?php
	namespace Eternal\Http\Controllers;

	use Hash;

	class IndexController extends Controller {

		public function getPage($page = '') {
			return view('pages.index.'.(empty($page) ? 'index' : $page));
		}

		public function getHash($value) {
			return Hash::make($value);
		}

		public function missingMethod($parameters = array()) {
			$parameters = explode('/', $parameters);
			return call_user_func_array(array($this,'getPage'), $parameters);
		}
	}
