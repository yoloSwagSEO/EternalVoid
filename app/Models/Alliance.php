<?php
    namespace Eternal\Models;

    use Request;

    /**
     * Class Alliance
     * @package Eternal\Models
     * @method where(string $column, string $operator, string $value, string $boolean = 'and')
     * @method orWhere(string $column, string $operator, mixed $value)
     */

    class Alliance extends Base {

        protected $table = 'alliances';

        public function search() {
            return $this->where('alliance_tag', 'LIKE', '%'.Request::get('searchterm').'%')
                        ->orWhere('alliance_name', 'LIKE', '%'.Request::get('searchterm').'%')
                        ->get();
        }

    }