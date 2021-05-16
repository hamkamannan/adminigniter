<?php

namespace hamkamannan\adminigniter\Modules\Core\Menu\Controllers;

class Menu extends \hamkamannan\adminigniter\Controllers\BaseController
{
    protected $auth;
    protected $authorize;
    protected $menuModel;
    protected $menuCategoryModel;
    
    function __construct()
    {
        $this->menuModel = new \hamkamannan\adminigniter\Modules\Core\Menu\Models\MenuModel();
        $this->menuCategoryModel = new \hamkamannan\adminigniter\Modules\Core\Menu\Models\MenuCategoryModel();

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
            
            $save_data = array(
				'name' => $this->request->getPost('name'),
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

            $newMenuId = $this->menuModel->insert($save_data);
            if ($newMenuId) {
                set_message('toastr_msg', 'Menu berhasil disimpan');
                set_message('toastr_type', 'success');
                return redirect()->to('/menu?slug='.$slug);
            } else {
                set_message('message', 'Menu gagal disimpan');
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
