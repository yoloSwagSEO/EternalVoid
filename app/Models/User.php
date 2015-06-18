<?php
    namespace Eternal\Models;

    use Request;
    use Crypt;
    use Auth;
    use Hash;
    use Carbon\Carbon;

    /**
     * Class User
     * @package Eternal\Models
     *
     * @property int $id
     * @property string $username
     * @property string $password
     * @property string $remember_token
     * @property string $random
     * @property string $email
     * @property string $regip
     * @property string $lastip
     * @property mixed $created_at
     * @property int $created_uid
     * @property mixed $updated_at
     * @property int $updated_uid
     * @property mixed $deleted_at
     * @property int $deleted_uid
     * @property mixed $disabled_at
     * @property int $disabled_uid
     * @property mixed $lastactive_at
     * @property mixed $planets
     * @property mixed $research
     * @property mixed $profile
     * @property mixed $messages
     *
     * @method \Illuminate\Database\Query\Builder where(string $column, string $operator, string $value, string $boolean = 'and')
     * @method \Illuminate\Database\Query\Builder select(array $columns = array('*'))
     */

    class User extends Base {

        protected $table = 'users';
        protected $dates = [
            'lastactive_at'
        ];

        public function read($id = '', $with = []) {
            return !empty($id) ? $this->with($with)->find($id) : $this->with($with)->get();
        }

        public function add() {

        }

        public function modify() {

        }

        public function remove() {

        }

        public function search() {
            return $this->with([
                'planets' => function($query) {
                    return $query->where('base_id', '=', 1);
                }
            ])->where('username','LIKE','%'.Request::get('searchterm').'%')->get();
        }

        public function likeByUsername($term) {
            return $this->where('username','LIKE','%'.$term.'%')->get();
        }

        public static function getByUsername($username) {
            return self::where('username', '=', $username)->get()->first();
        }

        public function login() {
            $rules = [
                'username' => 'required',
                'password' => 'required',
            ];

            $messages = [
                'username.required' => trans('users.messages.login_username_required'),
                'password.required' => trans('users.messages.login_password_required'),
                'disabled'          => trans('users.messages.login_disabled_account'),
                'loginfailed'       => trans('users.messages.login_incorrect_login'),
            ];

            if($this->isValid($rules, $messages)) {
                $credentials = [
                    'username' => Request::get('username'),
                    'password' => Request::get('password'),
                ];

                if(Auth::attempt($credentials, Request::exists('remember'))) {
                    if(is_null(Auth::user()->disabled_at)) {
                        session(['universe' => Request::get('universe')]);
                        session(['baseId' => 1]);

                        return true;
                    }

                    $this->validator->messages()->add('disabled', $messages['disabled']);
                    $this->logout();

                    return false;
                }

                $this->validator->messages()->add('loginfailed', $messages['loginfailed']);
                return false;
            }

            return false;
        }

        public function logout() {
            session()->flush();
            Auth::logout();

            return true;
        }

        public function register() {
            $rules = [
                'username'    => 'required',
                'email'       => 'required|email',
                'password'    => 'required|same:password_cnf|min:8',
                'password_cnf'=> 'required|same:password',
            ];

            $messages = [
                'username.required' => trans('users.messages.login_username_required'),
                'password.required' => trans('users.messages.login_password_required'),
                'password.same'     => trans('users.messages.register_password_same'),
                'password.min'      => trans('users.messages.register_password_min'),
                'password_cnf.same' => trans('users.messages.register_password_cnf_same'),
                'email.required'    => trans('users.messages.register_email_required'),
                'email.email'       => trans('users.messages.register_email_email'),
                'registerfailed'    => trans('users.messages.login_incorrect_login'),
            ];

            if($this->isValid($rules, $messages)) {
                $this->username      = Request::get('username');
                $this->password      = Hash::make(Request::get('password'));
                $this->random        = str_random();
                $this->email         = Crypt::encrypt(Request::get('email'));
                $this->regip         = Crypt::encrypt(Request::ip());
                $this->lastip        = Crypt::encrypt(Request::ip());
                $this->created_uid   = 0;
                $this->updated_uid   = 0;
                $this->lastactive_at = Carbon::now();

                if($this->save()) return true;

                $this->validator->messages()->add('registerfailed', $messages['registerfailed']);
                return false;
            }

            return false;
        }

        public function setLastactive(User $user) {
            $user->lastactive_at = Carbon::now();
            return $user->save();
        }

        /**
         * @return mixed
         */
        public function getAll() {
            return $this->select(['id', 'lastactive_at'])->get();
        }

        public function planets() {
            return $this->hasMany('Eternal\Models\Planet', 'user_id', 'id');
        }

        public function research() {
            return $this->hasOne('Eternal\Models\Research', 'user_id', 'id');
        }

        public function profile() {
            return $this->hasOne('Eternal\Models\UserProfile', 'user_id', 'id');
        }

        public function messages() {
            return $this->hasMany('Eternal\Models\Message', 'receiver_id', 'id')->select(['id', 'receiver_id', 'read_at']);
        }
    }