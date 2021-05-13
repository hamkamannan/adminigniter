<?php

namespace hamkamannan\adminigniter\Modules\Core\Permission\Controllers;

class Permission extends \hamkamannan\adminigniter\Controllers\BaseController
{
    protected $auth;
    protected $authorize;
    protected $permissionModel;

    function __construct()
    {
        $this->permissionModel = new \hamkamannan\adminigniter\Modules\Core\Permission\Models\PermissionModel();

        $this->auth = \Myth\Auth\Config\Services::authentication();
        $this->authorize = \Myth\Auth\Config\Services::authorization();

        if (! $this->auth->check() )
		{
            $this->session = service('session');
			$this->session->set('redirect_url', current_url() );
			return redirect()->route('login');
		} else {
			return redirect()->route('dashboard');
		}
    }

    public function index()
    {
        if (!is_allowed('permission/access')) {
            set_message('toastr_msg', lang('App.permission.not.have'));
            set_message('toastr_type', 'error');
            return redirect()->to('/dashboard');
        }

        $permissions = $this->permissionModel->findAll();
        $this->data['title'] = 'Permissions';
        $this->data['message'] = $this->validation->getErrors() ? $this->validation->listErrors() : $this->session->getFlashdata('message');
        $this->data['permissions'] = $permissions;
        echo view(APPPATH.'Modules/Core/Permission/Views/list', $this->data);
    }

    public function delete(int $id = 0)
    {
        if (!is_allowed('permission/delete')) {
            set_message('toastr_msg', lang('App.permission.not.have'));
            set_message('toastr_type', 'error');
            return redirect()->to('/dashboard');
        }

        if (!$id) {
            set_message('toastr_msg', 'Sorry you have to provide parameter(id)');
            set_message('toastr_type', 'error');
            return redirect()->to('/home');
        }

        $pemrissionDelete = $this->authorize->deletePermission($id);
        if ($pemrissionDelete) {
            set_message('toastr_msg', lang('Permission.info.success.delete'));
            set_message('toastr_type', 'success');
            return redirect()->to('/permission');
        } else {
            set_message('toastr_msg', lang('Permission.info.fail.update'));
            set_message('toastr_type', 'warning');
            set_message('message', lang('Permission.info.fail.update'));
            return redirect()->to('/permission/delete/' . $id);
        }
    }
}
