<?php

namespace App\Adminigniter\Modules\Backend\Banner\Models;

class BannerModel extends \hamkamannan\adminigniter\Models\BaseModel
{
    protected $table      = 't_banner';
    protected $primaryKey = 'id';
    protected $returnType     = 'object';
    protected $useSoftDeletes = false;
    protected $allowedFields = [
        'id', 'name', 'description', 'file_image', 'sort', 'url', 'url_title', 'url_target',  'active', 'category_id'
    ];
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';
    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = true;
}
