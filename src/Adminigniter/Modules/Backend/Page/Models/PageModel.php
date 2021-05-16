<?php

namespace App\Adminigniter\Modules\Backend\Page\Models;

class PageModel extends \hamkamannan\adminigniter\Models\BaseModel
{
    protected $table      = 't_page';
    protected $primaryKey = 'id';
    protected $returnType     = 'object';
    protected $useSoftDeletes = false;
    protected $allowedFields = [
        'id', 'title', 'slug', 'content', 'file_image', 'created_by', 'updated_by', 'description',
    ];
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';
    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = true;

}
