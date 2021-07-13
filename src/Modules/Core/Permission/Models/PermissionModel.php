<?php

namespace hamkamannan\adminigniter\Modules\Core\Permission\Models;

use Myth\Auth\Authorization\PermissionModel as MythModel;

class PermissionModel extends MythModel
{
    protected $returnType = 'object';
    protected $protectFields = false;
    protected $allowedFields = [
        'name', 'description'
    ];
}
