<?php

namespace App\Adminigniter\Modules\Backend\Banner\Controllers;

use \CodeIgniter\Files\File;

class Banner extends \hamkamannan\adminigniter\Controllers\BaseController
{
    protected $auth;
    protected $authorize;
    protected $bannerModel;
    protected $uploadPath;
    protected $modulePath;
    
    function __construct()
    {
        $this->bannerModel = new \App\Adminigniter\Modules\Backend\Banner\Models\BannerModel();
        $this->uploadPath = ROOTPATH . 'public/uploads/';
        $this->modulePath = ROOTPATH . 'public/uploads/banner/';
        
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
        if (!is_allowed('banner/access')) {
            set_message('toastr_msg', lang('App.permission.not.have'));
            set_message('toastr_type', 'error');
            return redirect()->to('/dashboard');
        }

        $banners = $this->bannerModel
            ->select('t_banner.*')
            ->select('c_references.name as category')
            ->join('c_references','c_references.id = t_banner.category_id','left')
            ->findAll();

        $this->data['title'] = 'Banner';
        $this->data['message'] = $this->validation->getErrors() ? $this->validation->listErrors() : $this->session->getFlashdata('message');
        $this->data['banners'] = $banners;
        // echo view('backend/banner/list', $this->data);
        echo view(APPPATH.'Adminigniter/Modules/Backend/Banner/Views/list', $this->data);
    }

    public function edit(int $id = null)
    {
        if (!is_allowed('banner/update')) {
            set_message('toastr_msg', lang('App.permission.not.have'));
            set_message('toastr_type', 'error');
            return redirect()->to('/dashboard');
        }

        $this->data['title'] = 'Ubah Banner';
        $banner = $this->bannerModel->find($id);
        $this->data['banner'] = $banner;

		$this->validation->setRule('name', 'Nama', 'required');
        $this->validation->setRule('category_id', 'Kategori', 'required');
        // $this->validation->setRule('file_image', 'Gambar', 'required');
        if ($this->request->getPost()) {
            if ($this->validation->withRequest($this->request)->run()) {
                $slug = url_title($this->request->getPost('name'), '-', TRUE);
                $update_data = [
                    'name' => $this->request->getPost('name'),
                    'category_id' => $this->request->getPost('category_id'),
                    'sort' => $this->request->getPost('sort'),
                    'description' => $this->request->getPost('description'),
                    'url' => $this->request->getPost('url'),
                    'url_title' => $this->request->getPost('url_title'),
                    'url_target' => $this->request->getPost('url_target'),
                    'updated_by' => user_id(),
                ];

                // Logic Upload
                $files = (array) $this->request->getPost('file_image');
                if (count($files)) {
                    $listed_file = array();
                    foreach ($files as $uuid => $name) {
                        if (file_exists($this->modulePath . $name)) {
                            $listed_file[] = $name;
                        } else {
                            if (file_exists($this->uploadPath . $name)) {
                                $file = new File($this->uploadPath . $name);
                                $newFileName = $file->getRandomName();
                                $file->move($this->modulePath, $newFileName);
                                $listed_file[] = $newFileName;
                            }
                        }
                    }
                    $update_data['file_image'] = implode(',', $listed_file);
                }
                $bannerUpdate = $this->bannerModel->update($id, $update_data);

                if ($bannerUpdate) {
                    add_log('Ubah Banner', 'banner', 'edit', 't_banner', $id);
                    set_message('toastr_msg', 'Banner berhasil diubah');
                    set_message('toastr_type', 'success');
                    return redirect()->to('/banner');
                } else {
                    set_message('toastr_msg', 'Banner gagal diubah');
                    set_message('toastr_type', 'warning');
                    set_message('message', 'Banner gagal diubah');
                    return redirect()->to('/banner/edit/' . $id);
                }
            }
        }


        if (file_exists($this->modulePath . '/' . $banner->file_image)) {
            $file = new \CodeIgniter\Files\File($this->modulePath . '/' . $banner->file_image);
            $this->data['image_size'] = $file->getSize('kb');
        } else {
            $this->data['image_size'] = 0;
        }

        $this->data['message'] = $this->validation->getErrors() ? $this->validation->listErrors() : $this->session->getFlashdata('message');
        $this->data['redirect'] = base_url('banner/edit/' . $id);
        echo view(APPPATH.'Adminigniter/Modules/Backend/Banner/Views/update', $this->data);
    }

    public function create()
    {
        if (!is_allowed('banner/create')) {
            set_message('toastr_msg', lang('App.permission.not.have'));
            set_message('toastr_type', 'error');
            return redirect()->to('/dashboard');
        }

        $this->data['title'] = 'Tambah Banner';

		$this->validation->setRule('name', 'Nama', 'required');
        $this->validation->setRule('category_id', 'Kategori', 'required');
		$this->validation->setRule('file_image', 'Gambar', 'required');
        if ($this->request->getPost() && $this->validation->withRequest($this->request)->run()) {

            $save_data = [
				'name' => $this->request->getPost('name'),
                'category_id' => $this->request->getPost('category_id'),
				'sort' => $this->request->getPost('sort'),
				'description' => $this->request->getPost('description'),
				'url' => $this->request->getPost('url'),
				'url_title' => $this->request->getPost('url_title'),
				'url_target' => $this->request->getPost('url_target'),
                'created_by' => user_id(),
            ];

            // Logic Upload
            $files = (array) $this->request->getPost('file_image');
            if (count($files)) {
                $listed_file = array();
                foreach ($files as $uuid => $name) {
                    if (file_exists($this->uploadPath . $name)) {
                        $file = new File($this->uploadPath . $name);
                        $newFileName = $file->getRandomName();
                        $file->move($this->modulePath, $newFileName);
                        $listed_file[] = $newFileName;
                    }
                }
                $save_data['file_image'] = implode(',', $listed_file);
            }
            $newBannerId = $this->bannerModel->insert($save_data);

            if ($newBannerId) {
                add_log('Tambah Banner', 'banner', 'create', 't_banner', $newBannerId);
                set_message('toastr_msg', 'Banner berhasil ditambah');
                set_message('toastr_type', 'success');
                return redirect()->to('/banner');
            } else {
                set_message('message', $this->validation->getErrors() ? $this->validation->listErrors() : 'Banner gagal ditambah');
                echo view(APPPATH.'Adminigniter/Modules/Backend/Banner/Views/add', $this->data);
            }
        } else {
            $this->data['redirect'] = base_url('banner/create');
            set_message('message', $this->validation->getErrors() ? $this->validation->listErrors() : $this->session->getFlashdata('message'));
            echo view(APPPATH.'Adminigniter/Modules/Backend/Banner/Views/add', $this->data);
        }
    }

    public function delete(int $id = 0)
    {
        if (!is_allowed('banner/delete')) {
            set_message('toastr_msg', lang('App.permission.not.have'));
            set_message('toastr_type', 'error');
            return redirect()->to('/dashboard');
        }

        if (!$id) {
            set_message('toastr_msg', 'Sorry you have to provide parameter (id)');
            set_message('toastr_type', 'error');
            return redirect()->to('/banner');
        }
        $bannerDelete = $this->bannerModel->delete($id);
        if ($bannerDelete) {
            add_log('Hapus Banner', 'banner', 'delete', 't_banner', $id);
            set_message('toastr_msg', 'Banner berhasil dihapus');
            set_message('toastr_type', 'success');
            return redirect()->to('/banner');
        } else {
            set_message('toastr_msg', 'Banner gagal dihapus');
            set_message('toastr_type', 'warning');
            set_message('message', 'Banner gagal dihapus');
            return redirect()->to('/banner/delete/' . $id);
        }
    }

    public function enable($id = null)
    {
        if (!is_allowed('banner/enable')) {
            set_message('toastr_msg', lang('App.permission.not.have'));
            set_message('toastr_type', 'error');
            return redirect()->to('/dashboard');
        }

        $bannerUpdate = $this->bannerModel->update($id, array('active' => 1));

        if ($bannerUpdate) {
            set_message('toastr_msg', 'Banner berhasil diaktifkan');
            set_message('toastr_type', 'success');
        } else {
            set_message('toastr_msg', 'Banner gagal diaktifkan');
            set_message('toastr_type', 'warning');
        }
        return redirect()->to('/banner');
    }

    public function disable($id = null )
    {
        if (!is_allowed('banner/disable')) {
            set_message('toastr_msg', lang('App.permission.not.have'));
            set_message('toastr_type', 'error');
            return redirect()->to('/dashboard');
        }

        $bannerUpdate = $this->bannerModel->update($id, array('active' => 0));

        if ($bannerUpdate) {
            set_message('toastr_msg', 'Banner berhasil dinonaktifkan');
            set_message('toastr_type', 'success');
        } else {
            set_message('toastr_msg', 'Banner gagal dinonaktifkan');
            set_message('toastr_type', 'warning');
        }
        return redirect()->to('/banner');
    }
}
