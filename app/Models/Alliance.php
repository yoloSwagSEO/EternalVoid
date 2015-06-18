<?php
    namespace Eternal\Models;

    use Request;

    /**
     * Class Alliance
     * @package Eternal\Models
     * @method \Illuminate\Database\Query\Builder where(string $column, string $operator, string $value, string $boolean = 'and')
     */

    class Alliance extends Base {

        protected $table = 'alliances';

        public function search() {
            return $this->where('alliance_tag', 'LIKE', '%'.Request::get('searchterm').'%')
                        ->orWhere('alliance_name', 'LIKE', '%'.Request::get('searchterm').'%')
                        ->get();
        }

    }