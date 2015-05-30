<?php
	namespace Eternal\Http\Controllers;

	use Hash;
	use Crypt;

	class IndexController extends Controller {

		public function getPage($page = '') {
			return view('pages.index.'.(empty($page) ? 'index' : $page));
		}

		public function missingMethod($parameters = array()) {
			$parameters = explode('/', $parameters);
			return call_user_func_array(array($this,'getPage'), $parameters);
		}
	}
