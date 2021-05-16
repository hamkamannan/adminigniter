<?php

namespace hamkamannan\adminigniter\Modules\Core\User\Controllers;

class User extends \hamkamannan\adminigniter\Controllers\BaseController
{
    protected $auth;
    protected $authorize;
    protected $userModel;
    protected $groupModel;

    function __construct()
    {
        $this->userModel = new \hamkamannan\adminigniter\Modules\Core\User\Models\UserModel();
        $this->groupModel = new \hamkamannan\adminigniter\Modules\Core\Group\Models\GroupModel();

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
        if (!is_allowed('user/access')) {
            set_message('toastr_msg', lang('App.permission.not.have'));
            set_message('toastr_type', 'error');
            return redirect()->to('/dashboard');
        }

        $this->data['identityColumn'] = $this->config->validFields;;
        $this->data['user'] = user();
        $this->data['title'] = lang('Core.index_heading');
        $this->data['message'] = $this->validation->getErrors() ? $this->validation->listErrors() : $this->session->getFlashdata('message');
        $this->data['users'] = $this->userModel->findAll();
        foreach ($this->data['users'] as $k => $user) {
            $this->data['users'][$k]->groups = $this->userModel->getGroups($user->id);
        }

        // dd($this->data['users']);

        echo view('hamkamannan\adminigniter\Modules\Core\User\Views\list', $this->data);
    }
    public function profile()
    {
        $this->detail(user_id(), true);
    }
    public function detail(int $id, $is_profile = false)
    {
        $this->data['title'] = ($is_profile) ? 'Profil User' : 'Detail User';
        $user = $this->userModel->find($id);
        $groups = $this->authorize->groups();
        $currentGroups = $this->userModel->getGroups($id);
        // $this->baseModel->setTable('auth_group_users');
        // $userGroups = $this->userModel->getGroups($id);
        // $currentGroupIds = array();
        // foreach ($userGroups as $values) {
        //     $currentGroupIds[] = $values['group_id'];
        // }

        $this->data['user'] = $user;
        $this->data['groups'] = $groups;
        $this->data['currentGroups'] = $currentGroups;
        // $this->data['currentGroupIds'] = $currentGroupIds;
        $this->data['is_profile'] = $is_profile;
        
        if($is_profile){
            echo view('hamkamannan\adminigniter\Modules\Core\User\Views\profile', $this->data);
        } else {
            echo view('hamkamannan\adminigniter\Modules\Core\User\Views\view', $this->data);
        }
    }

    public function delete(int $id = 0)
    {
        if (!is_allowed('user/delete')) {
            set_message('toastr_msg', lang('App.permission.not.have'));
            set_message('toastr_type', 'error');
            return redirect()->to('/dashboard');
        }

        if (!$id) {
            set_message('toastr_msg', 'Sorry you have to provide parameter (id)');
            set_message('toastr_type', 'error');
            return redirect()->to('/home');
        }

        $userDelete = $this->userModel->delete($id);
        if ($userDelete) {
            add_log('Hapus User', 'user', 'delete', 'auth_users', $id);
            set_message('toastr_msg', 'User berhasil dihapus');
            set_message('toastr_type', 'success');
            return redirect()->to('/user');
        } else {
            set_message('toastr_msg', 'User failed to delete');
            set_message('toastr_type', 'warning');
            set_message('message', 'Error');
            return redirect()->to('/user');
        }
    }
    
    public function enable(int $id, string $code = '')
    {
        if (!is_allowed('user/enable')) {
            set_message('toastr_msg', lang('App.permission.not.have'));
            set_message('toastr_type', 'error');
            return redirect()->to('/dashboard');
        }

        $activation = false;
        if ($code) {
            $activation = $this->userModel->update($id, array('active'=> 1));
        } else if (is_admin()) {
            $activation = $this->userModel->update($id, array('active'=> 1));
        }

        if ($activation) {
            set_message('toastr_msg', 'User berhasil diaktifkan');
            set_message('toastr_type', 'success');
            return redirect()->to('/user');
        } else {
            set_message('toastr_msg', 'User gagal diaktifkan');
            set_message('toastr_type', 'warning');
            set_message('message', 'User gagal diaktifkan');
            return redirect()->to('/user');
        }
    }

    public function disable(int $id)
    {
        if (!is_allowed('user/disable')) {
            set_message('toastr_msg', lang('App.permission.not.have'));
            set_message('toastr_type', 'error');
            return redirect()->to('/dashboard');
        }

        $deactivation = false;
        if (is_admin()) {
            $deactivation = $this->userModel->update($id, array('active'=> 0));
        }

        if ($deactivation) {
            set_message('toastr_msg', 'User berhasil dinonaktifkan');
            set_message('toastr_type', 'success');
            return redirect()->to('/user');
        } else {
            set_message('toastr_msg', 'User gagal dinonaktifkan');
            set_message('toastr_type', 'warning');
            set_message('message', 'User gagal dinonaktifkan');
            return redirect()->to('/user');
        }
    }
}
