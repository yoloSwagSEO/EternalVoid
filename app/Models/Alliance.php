<?php
    namespace Eternal\Models;

    use Request;

    class Alliance extends Base {

        protected $table = 'alliances';

        public function search() {
            return $this->where('alliance_tag', 'LIKE', '%'.Request::get('searchterm').'%')
                        ->orWhere('alliance_name', 'LIKE', '%'.Request::get('searchterm').'%')
                        ->get();
        }

    }