<?php
    namespace Eternal\Models;

    /**
     * Class Research
     * @package Eternal\Models
     *
     * @property int $user_id
     */

    class Research extends Base {

        public $timestamps = false;
        protected $table   = 'users_research';

        public function add(User $user) {
            $this->user_id = $user->id;

            return $this->save();
        }

    }