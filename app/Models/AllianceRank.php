<?php
    namespace Eternal\Models;

    use Carbon\Carbon;
    use Request;
    use Crypt;

    /**
     * Class AllianceRank
     * @package Eternal\Models
     *
     * @property int $id
     * @property int $alliance_id
     * @property mixed $created_at
     * @property int $created_uid
     * @property mixed $updated_at
     * @property int $updated_uid
     * @property mixed $deleted_at
     * @property int $deleted_uid
     * @property bool $edit_alliance
     * @property bool $delete_alliance
     * @property bool $view_members
     * @property bool $edit_members
     * @property bool $delete_members
     * @property bool $view_messages
     * @property bool $add_messages
     * @property bool $edit_messages
     * @property bool $delete_messages
     * @property bool $view_applications
     * @property bool $accept_applications
     * @property bool $decline_applications
     * @property bool $view_members_online
     * @property bool $view_reports
     * @property bool $changeable
     * @property bool $default
     * @property string $rank
     *
     */

    class AllianceRank extends Base {

        protected $table    = 'alliances_ranks';
        protected $fillable = [
            'alliance_id',
            'created_at',
            'created_uid',
            'updated_at',
            'updated_uid',
            'edit_alliance',
            'delete_alliance',
            'view_members',
            'edit_members',
            'delete_members',
            'view_messages',
            'add_messages',
            'edit_messages',
            'delete_messages',
            'view_applications',
            'accept_applications',
            'decline_applications',
            'view_members_online',
            'view_reports',
            'changeable',
            'default',
            'rank',
        ];

        public function read($id, $with = []) {
            $query = $this->with($with);

            return !empty($id) ? $query->find($id) : $query->get();
        }

        public function add() {

        }

        public function modify(AllianceRank $rank) {

        }

        public function remove(AllianceRank $rank) {

        }

        public function setFounderRank(Alliance $alliance) {
            $data = [
                'alliance_id'          => $alliance->id,
                'created_uid'          => $this->usr->id,
                'updated_uid'          => $this->usr->id,
                'edit_alliance'        => true,
                'delete_alliance'      => true,
                'view_members'         => true,
                'edit_members'         => true,
                'delete_members'       => true,
                'view_messages'        => true,
                'add_messages'         => true,
                'edit_messages'        => true,
                'delete_messages'      => true,
                'view_applications'    => true,
                'accept_applications'  => true,
                'decline_applications' => true,
                'view_members_online'  => true,
                'view_reports'         => true,
                'changeable'           => false,
                'default'              => true,
                'rank'                 => 'Gründer',
            ];

            return $this->create($data);
        }

        public function setMemberRank(Alliance $alliance) {
            $data = [
                'alliance_id'          => $alliance->id,
                'created_at'           => Carbon::now(),
                'created_uid'          => $this->usr->id,
                'updated_at'           => Carbon::now(),
                'updated_uid'          => $this->usr->id,
                'edit_alliance'        => false,
                'delete_alliance'      => false,
                'view_members'         => true,
                'edit_members'         => false,
                'delete_members'       => false,
                'view_messages'        => true,
                'add_messages'         => true,
                'edit_messages'        => false,
                'delete_messages'      => false,
                'view_applications'    => false,
                'accept_applicatiosn'  => false,
                'decline_applications' => false,
                'view_members_online'  => true,
                'view_reports'         => true,
                'changeable'           => true,
                'default'              => true,
                'rank'                 => 'Mitglied',
            ];

            return $this->create($data);
        }

    }