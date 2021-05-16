<?php 
namespace App\Adminigniter\Modules\Report\Models;

class ReportModel extends \hamkamannan\adminigniter\Models\BaseModel
{
    protected $table      = 'table';
    protected $primaryKey = 'id';
    protected $returnType     = 'object';
    protected $useSoftDeletes = true;
    protected $allowedFields = ['name', 'description'];
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';
    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = true;
}