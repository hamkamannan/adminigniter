<?php

namespace hamkamannan\adminigniter\Modules\Core\Reference\Models;

class ReferenceModel extends \hamkamannan\adminigniter\Models\BaseModel
{
    protected $table      = 'c_references';
    protected $primaryKey = 'id';
    protected $returnType     = 'object';
    protected $useSoftDeletes = false;
    protected $allowedFields = [
        'id', 'name', 'description', 'sort',  'active', 'menu_id'
    ];
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';
    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = true;
}
