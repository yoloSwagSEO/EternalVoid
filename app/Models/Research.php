<?php
    namespace Eternal\Models;

    class Research extends Base {

        public $timestamps = false;
        protected $table   = 'users_research';

        public function add(User $user) {
            $this->user_id = $user->id;

            return $this->save();
        }

    }