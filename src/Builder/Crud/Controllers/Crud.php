<?php

namespace Crud\Controllers;

use \CodeIgniter\Files\File;

class Crud extends \hamkamannan\adminigniter\Controllers\BaseController
{
    protected $auth;
    protected $authorize;
    protected $crudModel;
    protected $uploadPath;
    protected $modulePath;
    
    function __construct()
    {
        $this->language = \Config\Services::language();
		$this->language->setLocale('id');
        
        $this->crudModel = new \Crud\Models\CrudModel();
        $this->uploadPath = ROOTPATH . 'public/uploads/';
        $this->modulePath = ROOTPATH . 'public/uploads/crud/';
        
        if (!file_exists($this->uploadPath)) {
            mkdir($this->uploadPath);
        }

        if (!file_exists($this->modulePath)) {
            mkdir($this->modulePath);
        }

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
        if (!is_allowed('crud/access')) {
            set_message('toastr_msg', lang('App.permission.not.have'));
            set_message('toastr_type', 'error');
            return redirect()->to('/dashboard');
        }

        $query = $this->crudModel
            ->select('t_crud.*')
            ->select('created.username as created_name')
            ->select('updated.username as updated_name')
            ->join('users created','created.id = t_crud.created_by','left')
            ->join('users updated','updated.id = t_crud.updated_by','left');
            
        $cruds = $query->findAll();

        $this->data['title'] = 'Crud';
        $this->data['message'] = $this->validation->getErrors() ? $this->validation->listErrors() : $this->session->getFlashdata('message');
        $this->data['cruds'] = $cruds;
        echo view('Crud\Views\list', $this->data);
    }

    public function create()
    {
        if (!is_allowed('crud/create')) {
            set_message('toastr_msg', lang('App.permission.not.have'));
            set_message('toastr_type', 'error');
            return redirect()->to('/dashboard');
        }

        $this->data['title'] = 'Tambah Crud';

		$this->validation->setRule('name', 'Nama', 'required');
        if ($this->request->getPost() && $this->validation->withRequest($this->request)->run()) {
            $slug = url_title($this->request->getPost('name'), '-', TRUE);
            $save_data = [
				'name' => $this->request->getPost('name'),
                'slug' => $slug,
				'sort' => $this->request->getPost('sort'),
				'description' => $this->request->getPost('description'),
                'created_by' => user_id(),
            ];

            $newCrudId = $this->crudModel->insert($save_data);

            if ($newCrudId) {
                add_log('Tambah Crud', 'crud', 'create', 't_crud', $newCrudId);
                set_message('toastr_msg', lang('Crud.info.successfully_saved'));
                set_message('toastr_type', 'success');
                return redirect()->to('/crud');
            } else {
                set_message('message', $this->validation->getErrors() ? $this->validation->listErrors() : lang('Crud.info.failed_saved'));
                echo view('Crud\Views\add', $this->data);
            }
        } else {
            $this->data['redirect'] = base_url('crud/create');
            set_message('message', $this->validation->getErrors() ? $this->validation->listErrors() : $this->session->getFlashdata('message'));
            echo view('Crud\Views\add', $this->data);
        }
    }

    public function edit(int $id = null)
    {
        if (!is_allowed('crud/update')) {
            set_message('toastr_msg', lang('App.permission.not.have'));
            set_message('toastr_type', 'error');
            return redirect()->to('/dashboard');
        }

        $this->data['title'] = 'Ubah Crud';
        $crud = $this->crudModel->find($id);
        $this->data['crud'] = $crud;

		$this->validation->setRule('name', 'Nama', 'required');
        if ($this->request->getPost()) {
            if ($this->validation->withRequest($this->request)->run()) {
                $slug = url_title($this->request->getPost('name'), '-', TRUE);
                $update_data = [
                    'name' => $this->request->getPost('name'),
                    'slug' => $slug,
                    'sort' => $this->request->getPost('sort'),
                    'description' => $this->request->getPost('description'),
                    'updated_by' => user_id(),
                ];

                $crudUpdate = $this->crudModel->update($id, $update_data);

                if ($crudUpdate) {
                    add_log('Ubah Crud', 'crud', 'edit', 't_crud', $id);
                    set_message('toastr_msg', 'Crud berhasil diubah');
                    set_message('toastr_type', 'success');
                    return redirect()->to('/crud');
                } else {
                    set_message('toastr_msg', 'Crud gagal diubah');
                    set_message('toastr_type', 'warning');
                    set_message('message', 'Crud gagal diubah');
                    return redirect()->to('/crud/edit/' . $id);
                }
            }
        }

        $this->data['message'] = $this->validation->getErrors() ? $this->validation->listErrors() : $this->session->getFlashdata('message');
        $this->data['redirect'] = base_url('crud/edit/' . $id);
        echo view('Crud\Views\update', $this->data);
    }

    public function delete(int $id = 0)
    {
        if (!is_allowed('crud/delete')) {
            set_message('toastr_msg', lang('App.permission.not.have'));
            set_message('toastr_type', 'error');
            return redirect()->to('/dashboard');
        }

        if (!$id) {
            set_message('toastr_msg', 'Sorry you have to provide parameter (id)');
            set_message('toastr_type', 'error');
            return redirect()->to('/crud');
        }
        $crudDelete = $this->crudModel->delete($id);
        if ($crudDelete) {
            add_log('Hapus Crud', 'crud', 'delete', 't_crud', $id);
            set_message('toastr_msg', lang('Crud.info.successfully_deleted'));
            set_message('toastr_type', 'success');
            return redirect()->to('/crud');
        } else {
            set_message('toastr_msg', lang('Crud.info.failed_deleted'));
            set_message('toastr_type', 'warning');
            set_message('message', lang('Crud.info.failed_deleted'));
            return redirect()->to('/crud/delete/' . $id);
        }
    }

    public function apply_status($id)
    {
        $field = $this->request->getVar('field');
        $value = $this->request->getVar('value');

        $crudUpdate = $this->crudModel->update($id, array($field => $value));

        if ($crudUpdate) {
            set_message('toastr_msg', ' Crud berhasil diubah');
            set_message('toastr_type', 'success');
        } else {
            set_message('toastr_msg', ' Crud gagal diubah');
            set_message('toastr_type', 'warning');
        }
        return redirect()->to('/crud');
    }
}
