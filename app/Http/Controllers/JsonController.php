<?php
    namespace Eternal\Http\Controllers;

    use Eternal\Models\User;

    use Request;

    class JsonController extends Controller {

        private $user;

        public function __construct(User $user) {
            $this->user = $user;
        }

        public function getReceivers() {
            if(Request::ajax()) {

                $users     = $this->user->likeByUsername(Request::get('term'));
                $usernames = [];

                foreach($users as $user) {
                    $usernames[] = $user->username;
                }

                return response()->json($usernames);
            }

            return response('', 403);
        }

    }