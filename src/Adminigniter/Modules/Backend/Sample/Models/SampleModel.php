<?php

namespace App\Adminigniter\Modules\Backend\Sample\Models;

class SampleModel extends \hamkamannan\adminigniter\Models\BaseModel
{
    protected $table      = 't_sample';
    protected $primaryKey = 'id';
    protected $returnType     = 'object';
    protected $useSoftDeletes = false;
    protected $allowedFields = [
        'id', 'slug', 'name', 'description', 'sort',  'active',
    ];
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';
    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = true;
}
