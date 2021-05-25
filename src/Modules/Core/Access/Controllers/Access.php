<?php

namespace hamkamannan\adminigniter\Modules\Core\Access\Controllers;

class Access extends \hamkamannan\adminigniter\Controllers\BaseController
{
    protected $auth;
    protected $authorize;
    protected $permissionModel;
    protected $groupModel;
    protected $menuModel;

    function __construct()
    {
        $this->permissionModel = new \hamkamannan\adminigniter\Modules\Core\Permission\Models\PermissionModel();
        $this->groupModel = new \hamkamannan\adminigniter\Modules\Core\Group\Models\GroupModel();
        $this->menuModel = new \hamkamannan\adminigniter\Modules\Core\Menu\Models\MenuModel();

        $this->auth = \Myth\Auth\Config\Services::authentication();
        $this->authorize = \Myth\Auth\Config\Services::authorization();
        $this->session = service('session');

        if (! $this->auth->check() )
		{
			$this->session->set('redirect_url', current_url() );
			return redirect()->route('login');
		} 
    }

    public function index()
    {
        if (!is_admin()) {
            set_message('toastr_msg', lang('App.permission.not.have'));
            set_message('toastr_type', 'error');
            return redirect()->to('/dashboard');
        }

        $keyword = $this->request->getVar('keyword');
        $group_id = $this->request->getVar('group_id') ?? 1;
        $group = $this->groupModel->find($group_id);
        $this->data['group'] = $group;

        $permissions = $this->groupModel->getPermissions($group_id);
        $access = array();
        foreach ($permissions as $permission) {
            $access[] = $permission['name'];
        }

        $query = $this->menuModel->where('parent', '0')->where('category_id', '1');
        if(!empty($keyword)){
            $query->groupStart();
            $query->like('name', $keyword);
            $query->orLike('controller', $keyword);
            $query->groupEnd();
        }
        $groups = $this->groupModel->findAll();
        $menus = $query->findAll();
        
        $this->data['title'] = 'Access';
        $this->data['message'] = $this->validation->getErrors() ? $this->validation->listErrors() : $this->session->getFlashdata('message');
        $this->data['groups'] = $groups;
        $this->data['menus'] = $menus;
        $this->data['access'] = $access;
        $this->data['group'] = $group;
        
        echo view('hamkamannan\adminigniter\Modules\Core\Access\Views\list', $this->data);
    }
}
