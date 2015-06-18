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

            return view('pages.game.'.$this->game['viewpath'].'.messages-'.$folder)->with([
                'messages'      => $messages,
                'message_count' => $this->messageCount
            ]);
        }

        public function getNew() {
            return view('pages.game.'.$this->game['viewpath'].'.messages-new')->with([
                'message_count' => $this->messageCount
            ]);
        }

        public function postNew($id = '') {
            if($this->message->add()) {
                return redirect('messages/outbox')->with(
                    'success', 'Deine Nachricht wurde erfolgreich versendet.'
                );
            }

            return redirect('messages/new'.(!empty($id) ? '/'.$id : ''))->withErrors($this->message->validator)->withInput();
        }

        public function getRead($id) {
            $message = $this->message->read($id, ['sender','receiver']);
            if(!is_null($message)) {
                if($message->receiver_id == $this->user->id || $message->sender_id == $this->user->id) {
                    $this->message->markAsRead($message);
                    return view('pages.game.'.$this->game['viewpath'].'.messages-read')->with([
                        'message'       => $message,
                        'message_count' => $this->messageCount
                    ]);
                }

                return redirect('messages')->with(
                    'error', 'Man '.$this->user->username.' du Stulle...ist doch nicht deine Nachricht...'
                );
            }

            return redirect('messages')->with(
                'success', $this->user->username.' wird dem Admin von Eternal Void jetzt ein Bier als Danke für\'s Testen ausgeben.'
            );
        }

        public function getMarkasread($id) {
            $message = $this->message->read($id);
            if(!is_null($message)) {
                if($message->receiver_id == $this->user->id) {
                    if($this->message->markAsRead($message)) {
                        return redirect()->back()->with(
                            'success', 'Die Nachricht wurde erfolgreich als gelesen markiert.'
                        );
                    }

                    return redirect()->back()->with(
                        'error', 'Die Nachricht konnte nicht als gelesen markiert werden.'
                    );
                }

                return redirect('messages')->with(
                    'error', 'Die gewünschte Nachricht kann nicht angezeigt werden.'
                );
            }

            return redirect('messages')->with(
                'error', 'Die gewünschte Nachricht ist unbekannt.'
            );
        }

        public function getReply($id) {
            $message = $this->message->read($id, ['sender','receiver']);
            if(!is_null($message)) {
                if($message->receiver_id == $this->user->id) {
                    return view('pages.game.'.$this->game['viewpath'].'.messages-new')->with([
                        'message'       => $message,
                        'message_count' => $this->messageCount,
                        'id'            => $id,
                    ]);
                }

                return redirect('messages')->with(
                    'error', 'Die gewünschte Nachricht kann nicht angezeigt werden.'
                );
            }

            return redirect('messages')->with(
                'error', 'Die gewünschte Nachricht ist unbekannt.'
            );
        }

        public function getMove($action, $messageId) {
            $message = $this->message->read($messageId);
            if(!is_null($message)) {
                if($message->receiver_id == $this->user->id || $message->sender_id == $this->user->id) {
                    if($this->message->move($action, $message)) {
                        return redirect()->back()->with(
                            'success', 'Die Nachricht wurde erfolgreich verschoben.'
                        );
                    }

                    return redirect()->back()->with(
                        'error', 'Die Nachricht konnte nicht verschoben werden.'
                    );
                }

                return redirect('messages')->with(
                    'error', 'Man du Stulle...ist doch nicht deine Nachricht...'
                );
            }

            return redirect('messages')->with(
                'error', 'Du Spaten sollst nicht willkürlich Nachrichten-ID\'s ausprobieren.'
            );
        }

        public function getExport() {
            return view('pages.game.'.$this->game['viewpath'].'.messages-export');
        }

        public function missingMethod($parameters = []) {
            return call_user_func_array([$this, 'getIndex'], [$parameters]);
        }
    }