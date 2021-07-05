<?php

namespace hamkamannan\adminigniter\Modules\Core\Menu\Controllers;

use \CodeIgniter\Files\File;

class Menu extends \hamkamannan\adminigniter\Controllers\BaseController
{
    protected $auth;
    protected $authorize;
    protected $menuModel;
    protected $menuCategoryModel;
    protected $uploadPath;
    protected $modulePath;
    
    function __construct()
    {
        $this->menuModel = new \hamkamannan\adminigniter\Modules\Core\Menu\Models\MenuModel();
        $this->menuCategoryModel = new \hamkamannan\adminigniter\Modules\Core\Menu\Models\MenuCategoryModel();
        $this->uploadPath = ROOTPATH . 'public/uploads/';
        $this->modulePath = ROOTPATH . 'public/uploads/menu/';
        
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
        if (!is_allowed('menu/access')) {
            set_message('toastr_msg', lang('App.permission.not.have'));
            set_message('toastr_type', 'error');
            return redirect()->to('/dashboard');
        }

        $slug = $this->request->getVar('slug');
        $this->data['title'] = 'Daftar Menu';

        $this->data['slug'] = $slug;
        $this->data['title'] = 'Menus';
        $this->data['message'] = $this->validation->getErrors() ? $this->validation->listErrors() : $this->session->getFlashdata('message');
        // $this->session->setFlashdata('toastr_msg', '');
        // $this->session->setFlashdata('toastr_type', '');
        echo view('hamkamannan\adminigniter\Modules\Core\Menu\Views\list', $this->data);
    }

    public function create()
    {
        $slug = $this->request->getVar('slug') ?? 'backend-menu';
        if (!is_allowed('menu/create')) {
            set_message('toastr_msg', lang('App.permission.not.have'));
            set_message('toastr_type', 'error');
            return redirect()->to('/dashboard');
        }

        $this->data['title'] = 'Tambah Menu';
		$this->validation->setRule('name', 'Label', 'required');
        if ($this->request->getPost() && $this->validation->withRequest($this->request)->run()) {
            $form_slug = url_title($this->request->getPost('name'), '-', TRUE);
            $save_data = array(
				'name' => $this->request->getPost('name'),
                'slug' => $form_slug,
				'controller' => $this->request->getPost('controller'),
				'icon' => $this->request->getPost('icon'),
				'permission' => implode('|', $this->request->getPost('permission')),
				'sort' => 0,
				'description' => $this->request->getPost('description'),
				'type' => $this->request->getPost('type'),
                'parent' => $this->request->getPost('parent') ?? 0,
                'category_id' => $this->request->getPost('category_id'),
			);

            $type = $this->request->getPost('type');
            if($type == 'label'){
                $save_data['icon'] = '';
                $save_data['permission'] = 'access';
            }

            // Logic Upload
            $files = (array) $this->request->getPost('file_image');
            if (count($files)) {
                $listed_file = array();
                foreach ($files as $uuid => $name) {
                    if (file_exists($this->uploadPath . $name)) {
                        $file = new File($this->uploadPath . $name);
                        $newFileName = $file->getFileName(); //$file->getRandomName();
                        $file->move($this->modulePath, $newFileName);
                        $listed_file[] = $newFileName;
                    }
                }
                $save_data['file_image'] = implode(',', $listed_file);
            }

            $newMenuId = $this->menuModel->insert($save_data);
            if ($newMenuId) {
                // set_message('toastr_msg', 'Menu berhasil disimpan');
                // set_message('toastr_type', 'success');
                $this->session->setFlashdata('toastr_msg', 'Menu berhasil disimpan');
                $this->session->setFlashdata('toastr_type', 'success');

                // $this->data['toastr_msg'] = 'Menu berhasil disimpan';
                // $this->data['toastr_type'] = 'success';
                return redirect()->to('/menu?slug='.$slug);
            } else {
                // set_message('message', 'Menu gagal disimpan');
                $this->session->setFlashdata('toastr_msg', 'Menu gagal disimpan');
                $this->session->setFlashdata('toastr_type', 'warning');
                // $this->data['toastr_msg'] = 'Menu gagal disimpan';
                // $this->data['toastr_type'] = 'warning';
                return redirect()->to('/menu/create?slug='.$slug);
            }
        } else {
            $message = $this->validation->getErrors() ? $this->validation->listErrors() : $this->session->getFlashdata('message');
            $this->data['message'] = $message;
            echo view('hamkamannan\adminigniter\Modules\Core\Menu\Views\add', $this->data);
        }
    }

    public function edit(int $id = 0)
    {
        $slug = $this->request->getVar('slug') ?? 'backend-menu';

        if (!is_allowed('menu/update')) {
            set_message('toastr_msg', lang('App.permission.not.have'));
            set_message('toastr_type', 'error');
            return redirect()->to('/dashboard');
        }

        $this->data['title'] = 'Ubah Menu';
        $menu = $this->menuModel->find($id);
        $this->validation->setRule('name', 'Label', 'required');
        if ($this->request->getPost()) {
            if ($this->validation->withRequest($this->request)->run()) {
                $update_data = array(
                    'name' => $this->request->getPost('name'),
                    'controller' => $this->request->getPost('controller'),
                    'icon' => $this->request->getPost('icon'),
                    'permission' => implode('|', $this->request->getPost('permission')),
                    'description' => $this->request->getPost('description'),
                    'type' => $this->request->getPost('type'),
                    'parent' => $this->request->getPost('parent') ?? 0,
                );

                if(!empty($this->request->getPost('form_slug'))){
                    $update_data['slug'] = $this->request->getPost('form_slug');
                }

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
                                $newFileName = $file->getFileName(); //$file->getRandomName();
                                $file->move($this->modulePath, $newFileName);
                                $listed_file[] = $newFileName;
                            }
                        }
                    }
                    $update_data['file_image'] = implode(',', $listed_file);
                }

                $menuUpdate = $this->menuModel->update($id, $update_data);
                if ($menuUpdate) {
                    set_message('toastr_msg', 'Menu berhasil diubah');
                    set_message('toastr_type', 'success');
                    return redirect()->to('/menu?slug='.$slug);
                } else {
                    set_message('toastr_msg', 'Menu gagal diubah');
                    set_message('toastr_type', 'warning');
                    set_message('message', 'Menu gagal diubah');
                    return redirect()->to('/menu/edit/' . $id);
                }
            }
        }
        $this->data['message'] = $this->validation->getErrors() ? $this->validation->listErrors() : $this->session->getFlashdata('message');
        $this->data['menu'] = $menu;
        echo view('hamkamannan\adminigniter\Modules\Core\Menu\Views\update', $this->data);
    }

    public function delete(int $id = 0)
    {
        $slug = $this->request->getVar('slug') ?? 'backend-menu';

        if (!is_allowed('menu/delete')) {
            set_message('toastr_msg', lang('App.permission.not.have'));
            set_message('toastr_type', 'error');
            return redirect()->to('/dashboard');
        }

        $menuDelete = $this->menuModel->delete($id);
        if ($menuDelete) {
            set_message('toastr_msg', 'Menu berhasil dihapus');
            set_message('toastr_type', 'success');
            return redirect()->to('/menu?slug='.$slug);
        } else {
            set_message('toastr_msg', 'Menu gagal dihapus');
            set_message('toastr_type', 'warning');
            set_message('message', 'Menu gagal dihapus');
            return redirect()->to('/menu?slug='.$slug);
        }
    }

    public function category_delete($id = null)
    {
        if (!is_allowed('menu/delete')) {
            set_message('toastr_msg', lang('App.permission.not.have'));
            set_message('toastr_type', 'error');
            return redirect()->to('/dashboard');
        }

        $menuCategoryDelete = $this->menuCategoryModel->delete($id);
        if ($menuCategoryDelete) {
            set_message('toastr_msg', 'Kategori Menu berhasil dihapus');
            set_message('toastr_type', 'success');
            return redirect()->to('/menu');
        } else {
            set_message('toastr_msg', 'Kategori Menu gagal dihapus');
            set_message('toastr_type', 'warning');
            set_message('message', 'Kategori Menu gagal dihapus');
            return redirect()->to('/menu');
        }
    }

}
