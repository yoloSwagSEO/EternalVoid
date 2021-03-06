<?php
    namespace Eternal\Models;

    use Request;
    use Carbon\Carbon;

    /**
     * Class Message
     * @package Eternal\Models
     *
     * @property int $receiver_id
     * @property int $sender_id
     * @property int $receiver_folder
     * @property int $sender_folder
     * @property mixed $created_at
     * @property int $created_uid
     * @property mixed $updated_at
     * @property int $updated_uid
     * @property mixed $deleted_at
     * @property int $deleted_uid
     * @property mixed $read_at
     * @property string $subject
     * @property string $message
     * @property User $sender
     * @property User $receiver
     *
     * @method where(string $column, string $operator, string $value, string $boolean = 'and')
     * @method insert(array $values)
     * @method selectRaw(string $expression, array $bindings = array())
     */

    class Message extends Base {

        protected $table = 'users_messages';

        public function read($id, $with = []) {
            return $this->with($with)
                        ->where('id', '=', $id)
                        ->get()
                        ->first();
        }

        public function add() {
            $rules = [
                'receiver' => 'required',
                'subject'  => 'required',
                'message'  => 'required',
            ];

            $messages = [
                'receiver.required' => 'Bitte gebe mindestens einen Empfänger an.',
                'subject.required'  => 'Bitte gebe einen Betreff für die Nachricht ein.',
                'message.required'  => 'Bitte gebe einen Text für die Nachricht ein.',
            ];

            if($this->isValid($rules, $messages)) {
                $data      = [];
                $receivers = array_unique(explode(',',str_replace(', ', ',', Request::get('receiver'))));
                foreach($receivers as $username) {
                    if(!empty($username)) {
                        $username = trim($username);

                        /* @var $user \Illuminate\Database\Eloquent\Collection */
                        $user     = User::getByUsername($username);

                        if(!$user->isEmpty()) {
                            $data[] = [
                                'sender_id'   => $this->usr->id,
                                'receiver_id' => $user[0]->id,
                                'created_at'  => Carbon::now(),
                                'created_uid' => $this->usr->id,
                                'updated_at'  => Carbon::now(),
                                'updated_uid' => $this->usr->id,
                                'subject'     => Request::get('subject'),
                                'message'     => Request::get('message')
                            ];
                        } else {
                            $this->validator->messages()->add('unknownreciever','Der folgende Empfänger ist unbekannt: '.$username);
                            return false;
                        }
                    }
                }

                if(!empty($data)) return $this->insert($data);

                $this->validator->messages()->add('sendfailed','Die Nachricht konnte nicht versendet werden.');
                return false;
            }

            return false;
        }

        public function in($folder, $with = []) {
            switch($folder) {
                case 'inbox':
                    return $this->with($with)
                        ->where([
                            'receiver_folder' => 1,
                            'receiver_id'     => $this->usr->id
                        ])->get();
                case 'outbox':
                    return $this->with($with)
                        ->where([
                            'sender_folder' => 2,
                            'sender_id'     => $this->usr->id
                        ])->get();
                case 'trash':
                    return $this->with($with)->where(
                        function($query) {
                            $query->where('receiver_id', '=', $this->usr->id)
                                  ->orWhere('sender_id', '=', $this->usr->id);
                        }
                    )->where(
                        function($query) {
                            $query->where('receiver_folder', '=', 3)
                                  ->orWhere('sender_folder', '=', 3);
                        }
                    )->get();
                default:
                    return null;
            }
        }

        public function move($action, Message $message) {
            $receiverFolder = $action == 'recover' ? 1 : ($action == 'trash' ? 3 : 4);
            $senderFolder   = $receiverFolder == 1 ? 2 : $receiverFolder;

            $message->read_at         = is_null($message->read_at) ? Carbon::now() : $message->read_at;
            $message->receiver_folder = $message->receiver_id == $this->usr->id ? $receiverFolder : $message->receiver_folder;
            $message->sender_folder   = $message->sender_id == $this->usr->id ? $senderFolder : $message->sender_folder;

            return $message->save();
        }

        public function markAsRead(Message $message) {
            if(is_null($message->read_at)) {
                $message->read_at = Carbon::now();

                return $message->save();
            }

            return true;
        }

        public function countMessages() {
            return $this->selectRaw('
				(SELECT COUNT(id) FROM eternal_'.$this->table.' WHERE receiver_id = '.$this->usr->id.' AND receiver_folder = 1) AS num_inbox,
				(SELECT COUNT(id) FROM eternal_'.$this->table.' WHERE sender_id = '.$this->usr->id.' AND sender_folder = 2) AS num_outbox,
			 	(SELECT COUNT(id) FROM eternal_'.$this->table.' WHERE (receiver_id = '.$this->usr->id.' OR sender_id = '.$this->usr->id.') AND (receiver_folder = 3 OR sender_folder = 3)) AS num_trash
			')->get()->first();
        }

        public function sender() {
            return $this->hasOne('Eternal\Models\User', 'id', 'sender_id');
        }

        public function receiver() {
            return $this->hasOne('Eternal\Models\User', 'id', 'receiver_id');
        }

    }