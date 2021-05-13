<?php 

namespace hamkamannan\adminigniterEntities;

use Myth\Auth\Entities\User as MythUser;
use Myth\Auth\Authorization\GroupModel;
use Myth\Auth\Authorization\PermissionModel;

class User extends MythUser
{
	protected $roles = [];

    protected $attributes = [
    	'first_name' => 'Guest',
    	'last_name'  => 'User',
		'phone'  => '021',
		'company' => 'Codeigniter'
    ];

	public function getName()
	{
		return trim(trim($this->attributes['first_name']) . ' ' . trim($this->attributes['last_name']));
	}

	public function getRoles()
    {
		$groups = (new GroupModel())->getGroupsForUser($this->id);

		foreach ($groups as $group)
		{
			$this->roles[$group['group_id']] = strtolower($group['name']);
		}

        return $this->roles;
	}
}
