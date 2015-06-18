<?php
    namespace Eternal\Models;

    use Illuminate\Database\Eloquent;

    use Validator;
    use Request;

    /**
     * Class Base
     * @package Eternal\Models
     *
     * @method Eloquent\Builder insert()
     * @method Eloquent\Builder where()
     * @method Eloquent\Builder find()
     * @method Eloquent\Builder first()
     * @method Eloquent\Builder orderBy()
     * @method Eloquent\Builder select()
     * @method Eloquent\Builder selectRaw()
     * @method Eloquent\Collection map()
     * @method Eloquent\Collection filter()
     * @method Eloquent\Collection count()
     */

    class Base extends Eloquent\Model {

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