<?php

namespace hamkamannan\adminigniter\Modules\Core\Group\Controllers;

class Group extends \hamkamannan\adminigniter\Controllers\BaseController
{
    protected $auth;
    protected $authorize;
    protected $userModel;
    protected $groupModel;

    function __construct()
    {
        $this->userModel = new \hamkamannan\adminigniter\Modules\Core\User\Models\UserModel();
        $this->groupModel = new \hamkamannan\adminigniter\Modules\Core\Group\Models\GroupModel();
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
        if (!is_allowed('group/access')) {
            set_message('toastr_msg', lang('App.permission.not.have'));
            set_message('toastr_type', 'error');
            return redirect()->to('/dashboard');
        }

        $groups = $this->authorize->groups();
        $this->data['title'] = 'Groups';
        $this->data['message'] = $this->validation->getErrors() ? $this->validation->listErrors() : $this->session->getFlashdata('message');
        $this->data['groups'] = $groups;
        $this->data['adminGroup'] = $this->config->defaultAdminGroup;
        $this->data['defaultGroup'] = $this->config->defaultUserGroup;
        echo view(APPPATH.'Modules/Core/Group/Views/list', $this->data);
    }

    public function detail(int $id)
    {
        if (!is_allowed('group/read')) {
            set_message('toastr_msg', lang('App.permission.not.have'));
            set_message('toastr_type', 'error');
            return redirect()->to('/dashboard');
        }

        $this->data['title'] = 'Detail User';
        $user = $this->auth->user($id)->row();
        $currentGroups = $this->auth->getUsersGroups($id)->getResult();
        $this->data['user'] = $user;
        $this->data['currentGroups'] = $currentGroups;
        $this->data['auth'] = $this->auth;
        echo view(APPPATH.'Modules/Core/Group/Views/view', $this->data);
    }

    public function delete(int $id = 0)
    {
        if (!is_allowed('group/delete')) {
            set_message('toastr_msg', lang('App.permission.not.have'));
            set_message('toastr_type', 'error');
            return redirect()->to('/dashboard');
        }

        if (!$id) {
            set_message('toastr_msg', 'Sorry you have to provide parameter(id)');
            set_message('toastr_type', 'error');
            return redirect()->to('/home');
        }

        $groupDelete = $this->authorize->deleteGroup($id);
        if ($groupDelete) {
            add_log('Hapus Group', 'param', 'delete', 'auth_groups', $id);
            set_message('toastr_msg', lang('Group.info.success.delete'));
            set_message('toastr_type', 'success');
            return redirect()->to('/group');
        } else {
            set_message('toastr_msg', lang('Group.info.fail.update'));
            set_message('toastr_type', 'warning');
            set_message('message', lang('Group.info.fail.update'));
            return redirect()->to('/group');
        }
    }

    public function enable($id = null)
    {
        $groupUpdate = $this->groupModel->update($id, array('active' => 1));

        if ($groupUpdate) {
            set_message('toastr_msg', 'Group berhasil diaktifkan');
            set_message('toastr_type', 'success');
            return redirect()->to('/group');
        } else {
            set_message('toastr_msg', 'Group gagal diaktifkan');
            set_message('toastr_type', 'warning');
            set_message('message', 'Group gagal diaktifkan');
            return redirect()->to('/group');
        }
    }

    public function disable($id = null )
    {
        $groupUpdate = $this->groupModel->update($id, array('active' => 0));

        if ($groupUpdate) {
            set_message('toastr_msg', 'Group berhasil dinonaktifkan');
            set_message('toastr_type', 'success');
            return redirect()->to('/group');
        } else {
            set_message('toastr_msg', 'Group gagal dinonaktifkan');
            set_message('toastr_type', 'warning');
            set_message('message', 'Group gagal dinonaktifkan');
            return redirect()->to('/group');
        }
    }
}
