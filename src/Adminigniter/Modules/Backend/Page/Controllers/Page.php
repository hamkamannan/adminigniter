<?php

namespace App\Adminigniter\Modules\Backend\Page\Controllers;

use \CodeIgniter\Files\File;


class Page extends \hamkamannan\adminigniter\Controllers\BaseController
{
    protected $auth;
    protected $authorize;
    protected $uploadPath;
    protected $modulePath;
    protected $uploadFile;
    
    function __construct()
    {
        $this->pageModel = new \App\Adminigniter\Modules\Backend\Page\Models\PageModel();
        $this->uploadPath = ROOTPATH . 'public/uploads/';
        $this->modulePath = ROOTPATH . 'public/uploads/page/';
        
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
        if (!is_allowed('page/access')) {
            set_message('toastr_msg', lang('App.permission.not.have'));
            set_message('toastr_type', 'error');
			return redirect()->to('/dashboard');
        }

        $this->data['title'] = 'Halaman';
        $this->data['message'] = $this->validation->getErrors() ? $this->validation->listErrors() : $this->session->getFlashdata('message');

        $this->data['pages'] = $this->pageModel->findAll();

        echo view(APPPATH.'Adminigniter/Modules/Backend/Page/Views/list', $this->data);
    }

    public function detail(int $id)
    {
        if (!is_allowed('page/read')) {
            set_message('toastr_msg', lang('App.permission.not.have'));
            set_message('toastr_type', 'error');
			return redirect()->to('/dashboard');
        }

        if (!$id) {
            set_message('toastr_msg', 'Sorry you have to provide parameter (id)');
            set_message('toastr_type', 'error');
            return redirect()->to('/home');
        }
        $this->data['title'] = 'Halaman - Detail';
        $this->data['page'] = $this->pageModel->getPages($id);
        echo view('backend/page/view', $this->data);
    }

    public function edit(int $id = null)
    {
        if (!is_allowed('page/update')) {
            set_message('toastr_msg', lang('App.permission.not.have'));
            set_message('toastr_type', 'error');
			return redirect()->to('/dashboard');
        }

        $this->data['title'] = 'Edit Page';
        $page = $this->pageModel->find($id);
        $this->data['page'] = $page;

        $this->validation->setRule('title', 'Judul Halaman', 'required');
        $this->validation->setRule('content', 'Konten Halaman', 'required');
        if ($this->request->getPost()) {
            if ($this->validation->withRequest($this->request)->run()) {
                $slug = (!empty($this->request->getPost('slug')) ? $this->request->getPost('slug') : url_title($this->request->getPost('title'), '-', TRUE));
                $update_data = [
                    'title' => $this->request->getPost('title'),
                    'slug' => $slug,
                    'content' => $this->request->getPost('content'),
                    'description' => $this->request->getPost('description'),
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
                $pageUpdate = $this->pageModel->update($id, $update_data);

                if ($pageUpdate) {
                    add_log('Ubah Halaman', 'page', 'edit', 't_page', $id);
                    set_message('toastr_msg', 'Halaman berhasil diubah');
                    set_message('toastr_type', 'success');
                    return redirect()->to('/page');
                } else {
                    set_message('toastr_msg', 'Halaman gagal diubah');
                    set_message('toastr_type', 'warning');
                    set_message('message', 'Halaman gagal diubah');
                    return redirect()->to('/page/edit/' . $id);
                }
            }
        }


        if (file_exists($this->modulePath . '/' . $page->file_image)) {
            $file = new \CodeIgniter\Files\File($this->modulePath . '/' . $page->file_image);
            $this->data['image_size'] = $file->getSize('kb');
        } else {
            $this->data['image_size'] = 0;
        }

        $this->data['message'] = $this->validation->getErrors() ? $this->validation->listErrors() : $this->session->getFlashdata('message');
        $this->data['redirect'] = base_url('page/edit/' . $id);
        echo view(APPPATH.'Adminigniter/Modules/Backend/Page/Views/update', $this->data);
    }

    public function create()
    {
        if (!is_allowed('page/create')) {
            set_message('toastr_msg', lang('App.permission.not.have'));
            set_message('toastr_type', 'error');
			return redirect()->to('/dashboard');
        }

        $this->data['title'] = 'Tambah Halaman';

        $this->validation->setRule('title', 'Judul Halaman', 'required');
        $this->validation->setRule('content', 'Konten Halaman', 'required');
        if ($this->request->getPost() && $this->validation->withRequest($this->request)->run()) {

            $slug = url_title($this->request->getPost('title'), '-', TRUE);
            $save_data = [
                'title' => $this->request->getPost('title'),
                'slug' => $slug,
                'content' => $this->request->getPost('content'),
                'description' => $this->request->getPost('description'),
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
            $newPageId = $this->pageModel->insert($save_data);

            if ($newPageId) {
                add_log('Tambah Halaman', 'page', 'create', 't_page', $newPageId);
                set_message('toastr_msg', 'Halaman berhasil ditambah');
                set_message('toastr_type', 'success');
                return redirect()->to('/page');
            } else {
                set_message('message', $this->validation->getErrors() ? $this->validation->listErrors() : 'Halaman gagal ditambah');
                echo view(APPPATH.'Adminigniter/Modules/Backend/Page/Views/add', $this->data);
            }
        } else {
            $this->data['redirect'] = base_url('page/create');
            set_message('message', $this->validation->getErrors() ? $this->validation->listErrors() : $this->session->getFlashdata('message'));
            echo view(APPPATH.'Adminigniter/Modules/Backend/Page/Views/add', $this->data);
        }
    }
    public function delete(int $id = 0)
    {
        if (!is_allowed('page/delete')) {
            set_message('toastr_msg', lang('App.permission.not.have'));
            set_message('toastr_type', 'error');
			return redirect()->to('/dashboard');
        }

        if (!$id) {
            set_message('toastr_msg', 'Sorry you have to provide parameter (id)');
            set_message('toastr_type', 'error');
            return redirect()->to('/home');
        }
        $pageDelete = $this->pageModel->delete($id);
        if ($pageDelete) {
            add_log('Hapus Halaman', 'page', 'delete', 't_page', $id);
            set_message('toastr_msg', 'Halaman berhasil dihapus');
            set_message('toastr_type', 'success');
            return redirect()->to('/page');
        } else {
            set_message('toastr_msg', 'Halaman gagal dihapus');
            set_message('toastr_type', 'warning');
            set_message('message', 'Halaman gagal dihapus');
            return redirect()->to('/page/delete/' . $id);
        }
    }
}
