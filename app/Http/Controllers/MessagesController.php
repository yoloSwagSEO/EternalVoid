<?php
	namespace Eternal\Http\Controllers;

	use Eternal\Libraries\Main;
	use Eternal\Models\Message;

	class MessagesController extends MainController {

		private $message;
		private $messageCount;

		public function __construct(Main $main, Message $message) {
			parent::__construct($main);
			$message->setCurrentUser($this->user);

			$this->message      = $message;
			$this->messageCount = $message->countMessages();
		}

		public function getIndex($folder = 'inbox') {
			$messages = $this->message->in($folder, ['sender', 'receiver']);

			return view('pages.game.'.$this->game['viewpath'].'.messages-'.$folder)->withMessages($messages)
				                                                                   ->withMessageCount($this->messageCount);
		}

		public function getNew() {
			return view('pages.game.'.$this->game['viewpath'].'.messages-new')->withMessageCount($this->messageCount);
		}

		public function postNew() {
			if($this->message->add()) {
				return redirect('messages/outbox')->withSuccess('Deine Nachricht wurde erfolgreich versendet.');
			}

			return redirect('messages/new')->withErrors($this->message->validator)->withInput();
		}

		public function getRead($id) {
			$message      = $this->message->read($id, ['sender','receiver']);
			if(!is_null($message)) {
				if($message->receiver_id == $this->user->id) {
					$this->message->markAsRead($message);
					return view('pages.game.'.$this->game['viewpath'].'.messages-read')->withMessage($message)
																					   ->withMessageCount($this->messageCount);
				}

				return redirect()->back()->withError('Die gewünschte Nachricht kann nicht angezeigt werden.');
			}

			return redirect()->back()->withError('Die gewünschte Nachricht ist unbekannt.');
		}

		public function getMarkasread($id) {
			$message = $this->message->read($id);
			if(!is_null($message)) {
				if($message->receiver_id == $this->user->id) {
					if($this->message->markAsRead($message)) {
						return redirect()->back()->withSuccess('Die Nachricht wurde erfolgreich als gelesen markiert.');
					}

					return redirect()->back()->withError('Die Nachricht konnte nicht als gelesen markiert werden.');
				}

				return redirect()->back()->withError('Die gewünschte Nachricht kann nicht angezeigt werden.');
			}

			return redirect()->back()->withError('Die gewünschte Nachricht ist unbekannt.');
		}

		public function getReply($id) {
			$message = $this->message->read($id, ['sender','receiver']);
			if(!is_null($message)) {
				if($message->receiver_id == $this->user->id) {
					return view('pages.game.'.$this->game['viewpath'].'.messages-new')->withMessage($message)
																					  ->withMessageCount($this->messageCount);
				}

				return redirect()->back()->withError('Die gewünschte Nachricht kann nicht angezeigt werden.');
			}

			return redirect()->back()->withError('Die gewünschte Nachricht ist unbekannt.');
		}

		public function postReply($id) {
			if($this->message->add()) {
				return redirect('messages')->withSuccess('Deine Nachricht wurde erfolgreich versendet.');
			}

			return redirect('message/reply/'.$id)->withErrors($this->message->validator)->withInput();
		}

		public function getMoveto($folder, $id) {
			$message = $this->message->read($id);
			if(!is_null($message)) {
				if($message->receiver_id == $this->user->id || $message->sender_id == $this->user->id) {
					if($this->message->moveTo($folder, $message)) {
						return redirect()->back()->withSuccess('Die Nachricht wurde erfolgreich verschoben.');
					}

					return redirect()->back()->withError('Die Nachricht konnte nicht verschoben werden.');
				}

				return redirect()->back()->withError('Die zu verschiebende Nachricht kann nicht verschoben werden.');
			}

			return redirect()->back()->withError('Die zu verschiebende Nachricht ist unbekannt.');
		}

		public function getRecover($id) {
			$message = $this->message->read($id);
			if(!is_null($message)) {
				if($message->receiver_id == $this->user->id || $message->sender_id == $this->user->id) {
					if($this->message->recover($message)) {
						return redirect()->back()->withSuccess('Die Nachricht wurde erfolgreich wiederhergestellt.');
					}

					return redirect()->back()->withError('Die Nachricht konnte nicht wiederhergestellt werden.');
				}

				return redirect()->back()->withError('Die wiederherzustellende Nachricht kann nicht wiederhergestellt werden.');
			}

			return redirect()->back()->withError('Die wiederherzustellende Nachricht ist unbekannt.');
		}

		public function getDelete($id) {
			$message = $this->message->read($id);
			if(!is_null($message)) {
				if($message->receiver_id == $this->user->id || $this->message->sender_id == $this->user->id) {
					if($this->message->remove($message)) {
						return redirect()->back()->withSuccess('Die Nachricht wurde erfolgreich gelöscht.');
					}

					return redirect()->back()->withError('Die Nachricht konnte nicht gelöscht werden.');
				}

				return redirect()->back()->withError('Die zu löschende Nachricht kann nicht gelöscht werden.');
			}

			return redirect()->back()->withError('Die zu löschende Nachricht ist unbekannt.');
		}

		public function getExport() {
			return view('pages.game.'.$this->game['viewpath'].'.messages-export');
		}

		public function missingMethod($parameters = []) {
			return call_user_func_array([$this, 'getIndex'], [$parameters]);
		}
	}