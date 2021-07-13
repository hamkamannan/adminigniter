<?php

namespace hamkamannan\adminigniter\Modules\Core\Parameter\Models;

class ParameterModel extends \hamkamannan\adminigniter\Models\BaseModel
{
    protected $table      = 'c_parameters'; 
    protected $primaryKey = 'id';
    protected $returnType     = 'object';
    protected $useSoftDeletes = false;
    protected $protectFields = false;
    protected $allowedFields = ['name', 'value', 'description'];
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';
    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = true;
}
