<?php

namespace hamkamannan\adminigniter\Modules\Core\Menu\Models;

class MenuCategoryModel extends \hamkamannan\adminigniter\Models\BaseModel
{
    protected $table      = 'c_menus_categories';
    protected $primaryKey = 'id';
    protected $returnType     = 'object';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['name', 'slug', 'sort', 'description', 'active'];
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';
    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = true;
}
