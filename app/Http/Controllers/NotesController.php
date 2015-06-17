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

        public function getRead($id) {
            $note = $this->note->read($id);
            if(!is_null($note)) {
                if($note->user_id == $this->user->id) {
                    return view('pages.game.'.$this->game['viewpath'].'.notes-read')->with([
                        'note' => $note
                    ]);
                }

                return redirect('notes')->with(
                    'error', 'Die gewünschte Notiz kann nicht angezeigt werden.'
                );
            }

            return redirect('notes')->with(
                'error', 'Die gewünschte Notiz existiert nicht.'
            );
        }

        public function getNew() {
            return view('pages.game.'.$this->game['viewpath'].'.notes-new');
        }

        public function getEdit($id) {
            $note = $this->note->read($id);
            if(!is_null($note)) {
                if($note->user_id == $this->user->id) {
                    return view('pages.game.'.$this->game['viewpath'].'.notes-edit')->with([
                        'note' => $note
                    ]);
                }

                return redirect('notes')->with(
                    'error', 'Die zu bearbeitende Notiz kann nicht bearbeitet werden.'
                );
            }

            return redirect('notes')->with(
                'error', 'Die zu bearbeitende Notiz existiert nicht.'
            );
        }

        public function getDelete($id) {
            $note = $this->note->read($id);
            if(!is_null($note)) {
                if($note->user_id == $this->user->id) {
                    if($this->note->remove($note)) {
                        return redirect('notes')->with([
                            'success' => 'Die Notiz wurde erfolgreich gelöscht.'
                        ]);
                    }

                    return redirect('notes')->with(
                        'error', 'Die Notiz konnte nicht gelöscht werden.'
                    );
                }

                return redirect('notes')->with(
                    'error', 'Die gewünschte Notiz kann nicht gelöscht werden.'
                );
            }

            return redirect('notes')->with(
                'error', 'Die gewünschte Notiz existiert nicht.'
            );
        }

        public function postNew() {
            if($this->note->add()) {
                return redirect('notes')->with(
                    'success', 'Die Notiz wurde erfolgreich erstellt.'
                );
            }

            return redirect('notes/new')->withInput()->withErrors($this->note->validator);
        }

        public function postEdit($id) {
            $note = $this->note->read($id);
            if(!is_null($note)) {
                if($note->user_id == $this->user->id) {
                    if($this->note->edit($note)) {
                        return redirect('notes')->with(
                            'success', 'Die Notiz wurde erfolgreich bearbeitet'
                        );
                    }

                    return redirect('notes/edit/'.$id)->withInput()->withErrors($this->note->validator);
                }

                return redirect('notes')->with(
                    'error', 'Die zu bearbeitende Notiz kann nicht bearbeitet werden.'
                );
            }

            return redirect('notes')->with(
                'error', 'Die zu bearbeitende Notiz existiert nicht.'
            );
        }
    }