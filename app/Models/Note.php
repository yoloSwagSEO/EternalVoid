<?php
    namespace Eternal\Models;

    use Request;

    /**
     * Class Note
     * @package Eternal\Models
     *
     * @property int $user_id
     * @property mixed $created_at
     * @property int $created_uid
     * @property mixed $updated_at
     * @property int $updated_uid
     * @property mixed $deleted_at
     * @property int $deleted_uid
     * @property string $subject
     * @property string $note
     *
     * @method where(string $column, string $operator, string $value, string $boolean = 'and')
     */

    class Note extends Base {

        protected $table = 'users_notes';

        private $rules = [
            'subject' => 'required',
            'note'    => 'required',
        ];

        private $messages = [
            'subject.required' => 'Bitte gebe einen Betreff für die Notiz ein.',
            'note.required'    => 'Bitte gebe einen Text für die Notiz ein.',
        ];


        public function read($id = '') {
            return !empty($id) ? $this->where('user_id', '=', $this->usr->id)->find($id) : $this->where('user_id', '=', $this->usr->id)->get();
        }

        public function add() {
            if($this->isValid($this->rules, $this->messages)) {
                $this->user_id     = $this->usr->id;
                $this->created_uid = $this->usr->id;
                $this->updated_uid = $this->usr->id;
                $this->subject     = Request::get('subject');
                $this->note        = Request::get('note');

                if($this->save()) return true;

                $this->validator->messages()->add('addfailed','Die Notiz konnte nicht erstellt werden.');
                return false;
            }

            return false;
        }

        public function edit(Note $note) {
            if($this->isValid($this->rules, $this->messages)) {
                $note->subject = Request::get('subject');
                $note->note    = Request::get('note');

                if($note->save()) return true;

                $this->validator->messages()->add('editfailed','Die Notiz konnte nicht bearbeitet werden.');
                return false;
            }

            return false;
        }

        public function remove(Note $note) {
            if(is_null($note)) return true;

            return $note->delete();
        }

    }