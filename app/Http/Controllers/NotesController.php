<?php
    namespace Eternal\Http\Controllers;

    use Eternal\Libraries\Main;
    use Eternal\Models\Note;

    class NotesController extends MainController {

        private $note;

        public function __construct(Main $main, Note $note) {
            parent::__construct($main);
            $note->setCurrentUser($this->user);

            $this->note = $note;
        }

        public function getIndex() {
            $notes = $this->note->read();

            return view('pages.game.'.$this->game['viewpath'].'.notes-all')->with([
                'notes' => $notes
            ]);
        }

        public function getRead($noteId) {
            return $this->getNoteResponse('read', $noteId);
        }

        public function getNew() {
            return view('pages.game.'.$this->game['viewpath'].'.notes-new');
        }

        public function getEdit($noteId) {
            return $this->getNoteResponse('edit', $noteId);
        }

        public function getDelete($noteId) {
            $note = $this->retrieveNote($noteId);
            if($note instanceof Note) {
                if($this->note->remove($note)) {
                    return redirect('notes')->with(
                        'success', 'Die Notiz wurde erfolgreich gelöscht.'
                    );
                }

                return redirect('notes')->with(
                    'error', 'Die Notiz konnte nicht gelöscht werden.'
                );
            }

            return $note;
        }

        public function postNew() {
            if($this->note->add()) {
                return redirect('notes')->with(
                    'success', 'Die Notiz wurde erfolgreich erstellt.'
                );
            }

            return redirect('notes/new')->withInput()->withErrors($this->note->validator);
        }

        public function postEdit($noteId) {
            $note = $this->retrieveNote($noteId);
            if($note instanceof Note) {
                if($this->note->edit($note)) {
                    return redirect('notes')->with(
                        'success', 'Die Notiz wurde erfolgreich bearbeitet'
                    );
                }

                return redirect('notes/edit/'.$noteId)->withInput()->withErrors($this->note->validator);
            }

            return $note;
        }

        private function retrieveNote($noteId) {
            $note = $this->note->read($noteId);
            if(!is_null($note)) {
                if($note->user_id == $this->user->id) {
                    return $note;
                }

                return redirect('notes')->with(
                    'error', 'Diese Notiz gehört nicht zu deinem Account.'
                );
            }

            return redirect('notes')->with(
                'error', 'Diese Notiz existiert nicht.'
            );
        }

        private function getNoteResponse($action, $noteId) {
            $note = $this->retrieveNote($noteId);
            if($note instanceof Note) {
                return view('pages.game.'.$this->game['viewpath'].'.notes-'.$action)->with([
                    'note' => $note
                ]);
            }

            return $note;
        }
    }