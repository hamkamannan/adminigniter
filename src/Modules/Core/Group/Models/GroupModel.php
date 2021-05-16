<?php

namespace hamkamannan\adminigniter\Modules\Core\Group\Models;

use Myth\Auth\Authorization\GroupModel as MythModel;
use Myth\Auth\Authorization\PermissionModel;

class GroupModel extends MythModel
{
    protected $returnType = 'object';
    protected $allowedFields = [
        'name', 'description'
    ];

    public function getPermissions(int $groupId): array
    {
        $permissionModel = model(PermissionModel::class);
        $fromGroup = $permissionModel
            ->select('auth_permissions.*')
            ->join('auth_groups_permissions', 'auth_groups_permissions.permission_id = auth_permissions.id', 'inner')
            ->where('group_id', $groupId)
            ->findAll();

        $found = [];
        foreach ($fromGroup as $permission)
        {
            $found[$permission['id']] = $permission;
        }

        return $found;
    }
}
