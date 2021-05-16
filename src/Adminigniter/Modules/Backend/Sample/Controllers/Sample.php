<?php

namespace App\Adminigniter\Modules\Backend\Sample\Controllers;

use \CodeIgniter\Files\File;

class Sample extends \hamkamannan\adminigniter\Controllers\BaseController
{
    protected $auth;
    protected $authorize;
    protected $sampleModel;
    protected $uploadPath;
    protected $modulePath;
    
    function __construct()
    {
        $this->sampleModel = new \App\Adminigniter\Modules\Backend\Sample\Models\SampleModel();
        $this->uploadPath = ROOTPATH . 'public/uploads/';
        $this->modulePath = ROOTPATH . 'public/uploads/sample/';
        
        if (!file_exists($this->uploadPath)) {
            mkdir($this->uploadPath);
        }

        if (!file_exists($this->modulePath)) {
            mkdir($this->modulePath);
        }

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
        if (!is_allowed('sample/access')) {
            set_message('toastr_msg', lang('App.permission.not.have'));
            set_message('toastr_type', 'error');
            return redirect()->to('/dashboard');
        }

        $samples = $this->sampleModel
            ->select('t_sample.*')
            ->findAll();

        $this->data['title'] = 'Sample';
        $this->data['message'] = $this->validation->getErrors() ? $this->validation->listErrors() : $this->session->getFlashdata('message');
        $this->data['samples'] = $samples;
        // echo view('backend/sample/list', $this->data);
        echo view(APPPATH.'Adminigniter/Modules/Backend/Sample/Views/list', $this->data);
    }

    public function edit(int $id = null)
    {
        if (!is_allowed('sample/update')) {
            set_message('toastr_msg', lang('App.permission.not.have'));
            set_message('toastr_type', 'error');
            return redirect()->to('/dashboard');
        }

        $this->data['title'] = 'Ubah Sample';
        $sample = $this->sampleModel->find($id);
        $this->data['sample'] = $sample;

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

                $sampleUpdate = $this->sampleModel->update($id, $update_data);

                if ($sampleUpdate) {
                    add_log('Ubah Sample', 'sample', 'edit', 't_sample', $id);
                    set_message('toastr_msg', 'Sample berhasil diubah');
                    set_message('toastr_type', 'success');
                    return redirect()->to('/sample');
                } else {
                    set_message('toastr_msg', 'Sample gagal diubah');
                    set_message('toastr_type', 'warning');
                    set_message('message', 'Sample gagal diubah');
                    return redirect()->to('/sample/edit/' . $id);
                }
            }
        }

        $this->data['message'] = $this->validation->getErrors() ? $this->validation->listErrors() : $this->session->getFlashdata('message');
        $this->data['redirect'] = base_url('sample/edit/' . $id);
        echo view(APPPATH.'Adminigniter/Modules/Backend/Sample/Views/update', $this->data);
    }

    public function create()
    {
        if (!is_allowed('sample/create')) {
            set_message('toastr_msg', lang('App.permission.not.have'));
            set_message('toastr_type', 'error');
            return redirect()->to('/dashboard');
        }

        $this->data['title'] = 'Tambah Sample';

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

            $newSampleId = $this->sampleModel->insert($save_data);

            if ($newSampleId) {
                add_log('Tambah Sample', 'sample', 'create', 't_sample', $newSampleId);
                set_message('toastr_msg', 'Sample berhasil ditambah');
                set_message('toastr_type', 'success');
                return redirect()->to('/sample');
            } else {
                set_message('message', $this->validation->getErrors() ? $this->validation->listErrors() : 'Sample gagal ditambah');
                echo view(APPPATH.'Adminigniter/Modules/Backend/Sample/Views/add', $this->data);
            }
        } else {
            $this->data['redirect'] = base_url('sample/create');
            set_message('message', $this->validation->getErrors() ? $this->validation->listErrors() : $this->session->getFlashdata('message'));
            echo view(APPPATH.'Adminigniter/Modules/Backend/Sample/Views/add', $this->data);
        }
    }

    public function delete(int $id = 0)
    {
        if (!is_allowed('sample/delete')) {
            set_message('toastr_msg', lang('App.permission.not.have'));
            set_message('toastr_type', 'error');
            return redirect()->to('/dashboard');
        }

        if (!$id) {
            set_message('toastr_msg', 'Sorry you have to provide parameter (id)');
            set_message('toastr_type', 'error');
            return redirect()->to('/sample');
        }
        $sampleDelete = $this->sampleModel->delete($id);
        if ($sampleDelete) {
            add_log('Hapus Sample', 'sample', 'delete', 't_sample', $id);
            set_message('toastr_msg', 'Sample berhasil dihapus');
            set_message('toastr_type', 'success');
            return redirect()->to('/sample');
        } else {
            set_message('toastr_msg', 'Sample gagal dihapus');
            set_message('toastr_type', 'warning');
            set_message('message', 'Sample gagal dihapus');
            return redirect()->to('/sample/delete/' . $id);
        }
    }

    public function enable($id = null)
    {
        if (!is_allowed('sample/enable')) {
            set_message('toastr_msg', lang('App.permission.not.have'));
            set_message('toastr_type', 'error');
            return redirect()->to('/dashboard');
        }

        $sampleUpdate = $this->sampleModel->update($id, array('active' => 1));

        if ($sampleUpdate) {
            set_message('toastr_msg', 'Sample berhasil diaktifkan');
            set_message('toastr_type', 'success');
        } else {
            set_message('toastr_msg', 'Sample gagal diaktifkan');
            set_message('toastr_type', 'warning');
        }
        return redirect()->to('/sample');
    }

    public function disable($id = null )
    {
        if (!is_allowed('sample/disable')) {
            set_message('toastr_msg', lang('App.permission.not.have'));
            set_message('toastr_type', 'error');
            return redirect()->to('/dashboard');
        }

        $sampleUpdate = $this->sampleModel->update($id, array('active' => 0));

        if ($sampleUpdate) {
            set_message('toastr_msg', 'Sample berhasil dinonaktifkan');
            set_message('toastr_type', 'success');
        } else {
            set_message('toastr_msg', 'Sample gagal dinonaktifkan');
            set_message('toastr_type', 'warning');
        }
        return redirect()->to('/sample');
    }
}
