<?php
    namespace Eternal\Models;

    use Request;
    use Crypt;

    /**
     * Class Alliance
     * @package Eternal\Models
     *
     * @property int $id
     * @property mixed $created_at
     * @property int $created_uid
     * @property mixed $updated_at
     * @property int $updated_uid
     * @property mixed $deleted_at
     * @property int $deleted_uid
     * @property string $alliance_name
     * @property string $alliance_tag
     * @property string $alliance_description
     * @property string $alliance_background
     * @property string $alliance_logo
     * @property string $alliance_website
     */

    class Alliance extends Base {

        protected $table = 'alliances';

        public function read($allianceId = '', $with = []) {
            return !empty($allianceId) ? $this->with($with)->find($allianceId) : $this->with($with)->get();
        }

        public function readByTag($allianceTag, $with = []) {
            $allianceTag = urldecode($allianceTag);
            return $this->with($with)->where('alliance_tag', '=', $allianceTag)->get();
        }

        public function add() {
            $rules = [
                'alliance-name' => 'required|unique:alliances,alliance_name',
                'alliance-tag'  => 'required|unique:alliances,alliance_tag',
            ];

            $messages = [
                'alliance-name.required' => 'Bitte geben einen Namen für deine Allianz ein.',
                'alliance-name.unique'   => 'Es existiert bereits eine Allianz mit diesem Namen.',
                'alliance-tag.required'  => 'Bitte geben einen TAG für deine Allianz ein.',
                'alliance-tag.unique'    => 'Es existiert bereits eine Allianz mit diesem TAG.',
                'addfailed'              => 'Deine Allianz konnte aufgrund eines technischen Fehlers nicht erstellt werden.'
            ];

            if($this->isValid($rules, $messages)) {
                $this->created_uid   = $this->usr->id;
                $this->updated_uid   = $this->usr->id;
                $this->alliance_name = Request::get('alliance-name');
                $this->alliance_tag  = Request::get('alliance-tag');

                if($this->save()) return true;

                $this->validator->messages()->add('addfailed', $messages['addfailed']);
                return false;
            }

            return false;
        }

        public function modify(Alliance $alliance) {
            $rules = [
                'alliance-name' => 'required',
                'alliance-tag'  => 'required',
            ];

            $messages = [
                'alliance-name.required' => 'Bitte geben einen Namen für deine Allianz ein.',
                'alliance-tag.required'  => 'Bitte geben einen TAG für deine Allianz ein.',
                'editfailed'             => 'Deine Allianz konnte aufgrund eines technischen Fehlers nicht erstellt werden.'
            ];

            if($this->isValid($rules, $messages)) {
                $alliance->alliance_name        = Request::get('alliance-name');
                $alliance->alliance_tag         = Request::get('alliance-tag');
                $alliance->alliance_logo        = Crypt::encrypt(Request::get('alliance-logo'));
                $alliance->alliance_website     = Crypt::encrypt(Request::get('alliance-website'));
                $alliance->alliance_background  = Crypt::encrypt(Request::get('alliance-background'));
                $alliance->alliance_description = Crypt::encrypt(Request::get('alliance-description'));

                if($alliance->save()) return true;

                $this->validator->messages()->add('editfailed', $messages['editfailed']);
                return false;
            }

            return false;
        }

        public function remove(Alliance $alliance) {

        }

        public function search() {
            return $this->where('alliance_tag', 'LIKE', '%'.Request::get('searchterm').'%')
                        ->orWhere('alliance_name', 'LIKE', '%'.Request::get('searchterm').'%')
                        ->get();
        }

        public function members() {
            return $this->hasManyThrough('Eternal\Models\User', 'Eternal\Models\UserProfile', 'alliance_id', 'id');
        }

        public function memberCount() {
            return $this->hasManyThrough('Eternal\Models\User', 'Eternal\Models\UserProfile', 'alliance_id', 'id')->select(['users.id']);
        }
    }