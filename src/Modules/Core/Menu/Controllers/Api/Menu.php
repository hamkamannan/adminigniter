<?php

namespace hamkamannan\adminigniter\Modules\Core\Menu\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\Files\File;

class Menu extends ResourceController
{
	use ResponseTrait;
	protected $menuModel;
	protected $validation;
	protected $session;
	function __construct()
	{
		$this->session = session();
		$this->validation = service('validation');
		$this->auth = \Myth\Auth\Config\Services::authentication();
        $this->authorize = \Myth\Auth\Config\Services::authorization();
		
		helper(['app','auth']);
	
		$this->menuModel = new \hamkamannan\adminigniter\Modules\Core\Menu\Models\MenuModel();
		$this->menuCategoryModel = new \hamkamannan\adminigniter\Modules\Core\Menu\Models\MenuCategoryModel();
	}
	public function index()
	{
		$data = $this->menuModel->findAll();
		return $this->respond($data, 200);
	}

	public function delete($id = null)
	{
		$data = $this->menuModel->find($id);
		if ($data) {
			$this->menuModel->delete($id);
			$response = [
				'status'   => 200,
				'error'    => null,
				'messages' => [
					'success' => 'Menu berhasil dihapus'
				]
			];
			return $this->respondDeleted($response);
		} else {
			return $this->failNotFound('Data tidak ditemukan dengan ID: ' . $id);
		}
	}

	public function set_status()
	{
		$id = $this->request->getPost('id');
		$status = $this->request->getPost('status');
		$menu = $this->menuModel->find($id);
		$activation_status = ($status == 1) ? 'Aktif': 'Nonaktif';
		$message = 'Menu '.$menu->name. ' '.$activation_status;

		$moduleUpdate = $this->menuModel->update($id, array('active' => $status));
		if ($moduleUpdate) {
			$response = [
				'status'   => 201,
				'error'    => null,
				'messages' => [
					'success' => $message
				]
			];
			return $this->respond($response);
		} else {
			return $this->fail('<div class="alert alert-danger fade show" role="alert">Menu gagal diubah statusnya</div>', 400);
		}
	}

	private function _parse_menu($menus, $parent = '0')
	{
		foreach ($menus as $menu) {
			$this->sort++;
			$this->menus[] = [
				'id' => $menu['id'],
				'sort' => $this->sort,
				'parent' => $parent
			];
			if (isset($menu['children'])) {
				$this->_parse_menu($menu['children'], $menu['id']);
			}
		}
	}

	public function save_ordering()
	{
		$this->menus = [];
		$this->sort = 0;
		$this->_parse_menu($this->request->getPost('menu'));

		$moduleUpdate = $this->menuModel->updateBatch($this->menus, 'id');
		if ($moduleUpdate) {
			$response = [
				'status'   => 201,
				'error'    => null,
				'messages' => [
					'success' => 'Menu berhasil diubah'
				]
			];
			return $this->respond($response);
		} else {
			return $this->fail('<div class="alert alert-danger fade show" role="alert">Menu gagal diubah</div>', 400);
		}
	}

	public function category_create()
	{
		$this->validation->setRule('name', 'Nama Menu', 'required');		
		if ($this->request->getPost() && $this->validation->withRequest($this->request)->run()) {
			$slug = url_title($this->request->getPost('name'), '-', TRUE);
			$save_data = array(
				'name' => $this->request->getPost('name'),
				'slug' => $slug,
				'sort' => $this->request->getPost('sort'),
				'description' => $this->request->getPost('description'),
			);

			$newCategoryMenuId = $this->menuCategoryModel->insert($save_data);
			if ($newCategoryMenuId) {
				$this->session->setFlashdata('toastr_msg', 'Kategori Menu berhasil disimpan');
				$this->session->setFlashdata('toastr_type', 'success');
				$response = [
					'status'   => 201,
					'error'    => null,
					'messages' => [
						'success' => 'Kategori Menu berhasil disimpan'
					]
				];
				return $this->respondCreated($response);
			} else {
				$response = [
					'status'   => 400,
					'error'    => null,
					'messages' => [
						'error' => 'Kategori Menu gagal disimpan'
					]
				];
				return $this->fail($response);
			}
		} else {
			$message = $this->validation->listErrors();
			return $this->fail($message, 400);
		}
	}

	public function category_detail($id = null)
	{
		$data = $this->menuCategoryModel->find($id);
		if ($data) {
			return $this->respond($data);
		} else {
			return $this->failNotFound('Data tidak ditemukan dengan ID: ' . $id);
		}
	}

	public function category_edit($id = null)
	{
		$this->validation->setRule('name', 'Kategori Menu', 'required');
		if ($this->request->getPost() && $this->validation->withRequest($this->request)->run()) {
			$slug = url_title($this->request->getPost('name'), '-', TRUE);
			$update_data = array(
				'name' => $this->request->getPost('name'),
				'slug' => $slug,
				'sort' => $this->request->getPost('sort'),
				'description' => $this->request->getPost('description'),
			);

			$menuCategoryUpdate = $this->menuCategoryModel->update($id, $update_data);
			if ($menuCategoryUpdate) {
				$this->session->setFlashdata('toastr_msg', 'Kategori Menu berhasil disimpan');
				$this->session->setFlashdata('toastr_type', 'success');
				$response = [
					'status'   => 201,
					'error'    => null,
					'messages' => [
						'success' => 'Kategori Menu berhasil disimpan'
					]
				];
				return $this->respond($response);
			} else {
				return $this->fail('<div class="alert alert-danger fade show" role="alert">Kategori Menu gagal disimpan</div>', 400);
			}
		} else {
			$message = $this->validation->listErrors();
			return $this->fail($message, 400);
		}
	}
}
