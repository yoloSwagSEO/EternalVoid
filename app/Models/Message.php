<?php
	namespace Eternal\Models;

	use Request;

	class Message extends Base {

		protected $table = 'users_messages';

		public function getByReceiverId($userId) {
			return $this->whereReceiverId($userId)->whereReceiverfolder(1)->get();
		}

		public function read($id, $with = []) {
			return $this->with($with)->whereId($id)->where(function($query) {
				$query->whereReceiverId($this->usr->id)
					  ->orWhere('sender_id', '=', $this->usr->id);
			})->get()->first();
		}

		public function add() {
			$rules = array(
				'receiver' => 'required',
				'subject'  => 'required',
				'message'  => 'required',
			);

			$messages = array(
				'receiver.required' => 'Bitte gebe mindestens einen Empfänger an.',
				'subject.required'  => 'Bitte gebe einen Betreff für die Nachricht ein.',
				'message.required'  => 'Bitte gebe einen Text für die Nachricht ein.',
			);

			if($this->isValid($rules, $messages)) {
				$data      = array();
				$receivers = array_unique(explode(',',str_replace(', ', ',', Request::get('receiver'))));
				foreach($receivers as $username) {
					if(!empty($username)) {
						$username = trim($username);
						$user     = User::getByUsername($username);
						if(!$user->isEmpty()) {
							$data[] = array(
								'sender_id'   => $this->usr->id,
								'receiver_id' => $user[0]->id,
								'created_at'  => (new \DateTime())->format('Y-m-d H:i:s'),
								'created_uid' => $this->usr->id,
								'updated_at'  => (new \DateTime())->format('Y-m-d H:i:s'),
								'updated_uid' => $this->usr->id,
								'subject'     => Request::get('subject'),
								'message'     => Request::get('message')
							);
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
					return $this->with($with)->whereReceiverFolder(1)->whereReceiverId($this->usr->id)->get();
				break;
				case 'outbox':
					return $this->with($with)->whereSenderFolder(2)->whereSenderId($this->usr->id)->get();
				break;
				case 'trash':
					return $this->with($with)->where(function($query) {
						$query->whereReceiverId($this->usr->id)->orWhere('sender_id', '=', $this->usr->id);
					})->where(function($query) {
						$query->whereReceiverFolder(3)->orWhere('sender_folder', '=', 3);
					})->get();
				break;
			}
		}

		public function remove($message) {
			if($message->receiver_id == $this->usr->id) {
				$message->read_at         = (new \DateTime())->format('Y-m-d H:i:s');
				$message->receiver_folder = 4;
			}

			if($message->sender_id == $this->usr->id) {
				$message->sender_folder = 4;
			}

			return $message->save();
		}

		public function countMessages() {
			return $this->selectRaw('
				(SELECT COUNT(id) FROM eternal_'.$this->table.' WHERE receiver_id = '.$this->usr->id.' AND receiver_folder = 1) AS num_inbox,
				(SELECT COUNT(id) FROM eternal_'.$this->table.' WHERE sender_id = '.$this->usr->id.' AND sender_folder = 2) AS num_outbox,
			 	(SELECT COUNT(id) FROM eternal_'.$this->table.' WHERE (receiver_id = '.$this->usr->id.' OR sender_id = '.$this->usr->id.') AND (receiver_folder = 3 OR sender_folder = 3)) AS num_trash
			')->get()->first();
		}

		public function moveTo($folder, $message) {
			switch($folder) {
				case 'trash':
					if($message->receiver_id == $this->usr->id) $message->receiver_folder = 3;
					if($message->sender_id == $this->usr->id) $message->sender_folder = 3;
				break;
			}

			return $message->save();
		}

		public function recover($message) {
			if($message->receiver_id == $this->usr->id) $message->receiver_folder = 1;
			if($message->sender_id == $this->usr->id) $message->sender_folder = 2;

			return $message->save();
		}

		public function markAsRead($message) {
			if(is_null($message->read_at)) {
				$message->read_at = (new \DateTime())->format('Y-m-d H:i:s');

				return $message->save();
			}

			return true;
		}

		public function sender() {
			return $this->hasOne('Eternal\Models\User', 'id', 'sender_id');
		}

		public function receiver() {
			return $this->hasOne('Eternal\Models\User', 'id', 'receiver_id');
		}

	}