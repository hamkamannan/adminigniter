<?php

namespace hamkamannan\adminigniter\Modules\Core\Parameter\Controllers;

use DataTables\DataTables;

class Parameter extends \hamkamannan\adminigniter\Controllers\BaseController
{
    protected $auth;
    protected $authorize;
    protected $config;
    
    function __construct()
    {
        $this->parameterModel = new \hamkamannan\adminigniter\Modules\Core\Parameter\Models\ParameterModel();

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
        if (!is_allowed('parameter/access')) {
            set_message('toastr_msg', lang('App.permission.not.have'));
            set_message('toastr_type', 'error');
            return redirect()->to('/dashboard');
        }

        $this->data['title'] = 'Parameter';
        $this->data['message'] = $this->validation->getErrors() ? $this->validation->listErrors() : $this->session->getFlashdata('message');
        echo view('hamkamannan\adminigniter\Modules\Core\Parameter\Views\list', $this->data);
    }

    public function detail(int $id)
    {
        if (!is_allowed('parameter/read')) {
            set_message('toastr_msg', lang('App.permission.not.have'));
            set_message('toastr_type', 'error');
            return redirect()->to('/dashboard');
        }

        $this->data['title'] = 'Detail Parameter';
        $param = $this->parameterModel->find($id)->row();
        $this->data['param'] = $param;
        $this->data['auth'] = $this->auth;
        echo view('hamkamannan\adminigniter\Modules\Core\Parameter\Views\view', $this->data);
    }

    public function create()
    {
        if (!is_allowed('parameter/create')) {
            set_message('toastr_msg', lang('App.permission.not.have'));
            set_message('toastr_type', 'error');
            return redirect()->to('/dashboard');
        }

        $this->data['title'] = 'Create Group';
        $this->validation->setRule('name', 'Nama Parameter', 'required');
        $this->validation->setRule('value', 'Nilai Parameter', 'trim');
        if ($this->request->getPost() && $this->validation->withRequest($this->request)->run()) {
            $save_data = array(
                'name' => $this->request->getPost('name'),
                'value' => $this->request->getPost('value'),
                'description' => $this->request->getPost('description'),
            );

            $newParamId = $this->parameterModel->insert($save_data);
            if ($newParamId) {
                add_log('Tambah Parameter', 'param', 'create', 'c_parameters', $newParamId);
                set_message('toastr_msg', 'Parameter berhasil disimpan');
                set_message('toastr_type', 'success');
                return redirect()->to('/parameter');
            } else {
                set_message('message', 'Parameter gagal disimpan');
                return redirect()->to('/parameter/create/');
            }
        } else {
            $message = $this->validation->getErrors() ? $this->validation->listErrors() : $this->session->getFlashdata('message');
            $this->data['message'] = $message;
            echo view('hamkamannan\adminigniter\Modules\Core\Parameter\Views\add', $this->data);
        }
    }

    public function edit(int $id = 0)
    {
        if (!is_allowed('parameter/update')) {
            set_message('toastr_msg', lang('App.permission.not.have'));
            set_message('toastr_type', 'error');
            return redirect()->to('/dashboard');
        }

        if (!$id) {
            set_message('toastr_msg', 'Sorry you have to provide parameter (id)');
            set_message('toastr_type', 'error');
            return redirect()->to('/home');
        }

        $this->data['title'] = 'Edit Parameter';
        $param = $this->parameterModel->find($id);
        $this->validation->setRule('name', 'Nama Parameter', 'required');
        $this->validation->setRule('value', 'Nilai Parameter', 'trim');
        if ($this->request->getPost()) {
            if ($this->validation->withRequest($this->request)->run()) {
                $update_data = array(
                    'name' => $this->request->getPost('name'),
                    'value' => $this->request->getPost('value'),
                    'description' => $this->request->getPost('description'),
                );

                $paramUpdate = $this->parameterModel->update($id, $update_data);
                if ($paramUpdate) {
                    add_log('Ubah Parameter', 'param', 'edit', 'c_parameters', $id);
                    set_message('toastr_msg', 'Parameter berhasil disimpan');
                    set_message('toastr_type', 'success');
                    return redirect()->to('/parameter');
                } else {
                    set_message('toastr_msg', 'Parameter gagal disimpan');
                    set_message('toastr_type', 'warning');
                    set_message('message', 'Parameter gagal disimpan');
                    return redirect()->to('/parameter/edit/' . $id);
                }
            }
        }
        $this->data['message'] = $this->validation->getErrors() ? $this->validation->listErrors() : $this->session->getFlashdata('message');
        $this->data['param'] = $param;
        echo view('hamkamannan\adminigniter\Modules\Core\Parameter\Views\update', $this->data);
    }

    public function delete(int $id = 0)
    {
        if (!is_allowed('parameter/delete')) {
            set_message('toastr_msg', lang('App.permission.not.have'));
            set_message('toastr_type', 'error');
            return redirect()->to('/dashboard');
        }

        if (!$id) {
            set_message('toastr_msg', 'Sorry you have to provide parameter(id)');
            set_message('toastr_type', 'error');
            return redirect()->to('/home');
        }

        $paramDelete = $this->parameterModel->delete($id);
        if ($paramDelete) {
            add_log('Hapus Parameter', 'param', 'delete', 'c_parameters', $id);
            set_message('toastr_msg', 'Parameter berhasil dihapus');
            set_message('toastr_type', 'success');
            return redirect()->to('/param');
        } else {
            set_message('toastr_msg', 'Parameter gagal dihapus');
            set_message('toastr_type', 'warning');
            set_message('message', 'Parameter gagal dihapus');
            return redirect()->to('/param');
        }
    }

    public function set_access($status)
    {
        set_parameter('layout_param', $status);
    }

    public function json()
	{
		return DataTables::use('c_parameters')->make(true);
	}
}
