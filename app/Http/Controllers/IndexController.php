<?php
	namespace Eternal\Http\Controllers;

	class IndexController extends Controller {

		public function getIndex() {
			return view('pages.index.index');
		}

}
