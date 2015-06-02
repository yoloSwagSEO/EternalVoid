<?php
	namespace Eternal\Http\Controllers;

	class IndexController extends Controller {

		public function getPage($page = '') {
			return view('pages.index.'.(empty($page) ? 'index' : $page));
		}

		public function missingMethod($parameters = array()) {
			$parameters = explode('/', $parameters);
			return call_user_func_array([$this, 'getPage'], $parameters);
		}
	}
