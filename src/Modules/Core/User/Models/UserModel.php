<?php

namespace hamkamannan\adminigniter\Modules\Core\User\Models;

use Myth\Auth\Models\UserModel as MythModel;
use Myth\Auth\Authorization\GroupModel;

class UserModel extends MythModel
{
    protected $allowedFields = [
        'email', 'username', 'password_hash', 'reset_hash', 'reset_at', 'reset_expires', 'activate_hash',
        'status', 'status_message', 'active', 'force_pass_reset', 'permissions', 'deleted_at',
        'first_name', 'last_name', 'phone', 'section', 'department', 'division', 'unit', 'company','address'
    ];

    public function getGroups($user_id)
    {
        $roles = [];
		$groups = (new GroupModel())->getGroupsForUser($user_id);

		foreach ($groups as $group)
		{
			$roles[$group['group_id']] = strtolower($group['name']);
		}

        return $roles;
	}
}
