<?php
    namespace Eternal\Models;

    use Illuminate\Database\Eloquent\Model as Eloquent;

    use Validator;
    use Request;

    /**
     * Class Base
     * @package Eternal\Models
     *
     * @method \Illuminate\Database\Eloquent\Builder insert()
     * @method \Illuminate\Database\Eloquent\Builder where()
     * @method \Illuminate\Database\Eloquent\Builder find()
     * @method \Illuminate\Database\Eloquent\Builder first()
     * @method \Illuminate\Database\Eloquent\Builder orderBy()
     * @method \Illuminate\Database\Eloquent\Builder select()
     * @method \Illuminate\Database\Eloquent\Builder selectRaw()
     * @method \Illuminate\Database\Eloquent\Collection map()
     * @method \Illuminate\Database\Eloquent\Collection filter()
     * @method \Illuminate\Database\Eloquent\Collection count()
     */

    class Base extends Eloquent {

        /* @var $validator \Illuminate\Validation\Validator */
        public $validator;

        protected $usr;
        protected $plt;

        public function isValid($rules = [], $messages = []) {
            $this->validator = Validator::make(Request::all(), $rules, $messages);
            return $this->validator->passes();
        }

        public function setCurrentUser(User $user) {
            $this->usr = $user;

            return $this;
        }

        public function setCurrentPlanet(Planet $planet) {
            $this->plt = $planet;

            return $this;
        }

        protected function creator() {
            return $this->hasOne('Eternal\Models\User', 'created_uid', 'id');
        }

        protected function modifier() {
            return $this->hasOne('Eternal\Models\User', 'modified_uid', 'id');
        }

        protected function remover() {
            return $this->hasOne('Eternal\Models\User', 'deleted_uid', 'id');
        }

    }