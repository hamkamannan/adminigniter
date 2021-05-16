<?php

namespace App\Adminigniter\Modules\Backend\Banner\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\BannerModel;
use CodeIgniter\Files\File;

class Banner extends ResourceController
{
	use ResponseTrait;
	protected $bannerModel;
	protected $validation;
	protected $session;
	protected $modulePath;
	protected $uploadPath;

	function __construct()
	{
		helper(['url', 'text', 'form', 'auth', 'app', 'html']);
		$this->bannerModel = new \App\Adminigniter\Modules\Backend\Banner\Models\BannerModel();
		$this->validation = \Config\Services::validation();
		$this->session = session();
		$this->modulePath = ROOTPATH . 'public/uploads/banner/';
		$this->uploadPath = WRITEPATH . 'uploads/';

		if (!file_exists($this->modulePath)) {
			mkdir($this->modulePath);
		}
	}

	public function index()
	{
		if (!is_allowed('banner/access')) {
            set_message('toastr_msg', lang('App.permission.not.have'));
            set_message('toastr_type', 'error');
			return $this->respond(array('status' => 201, 'error' => lang('App.permission.not.have')));
        }

		$data = $this->bannerModel->findAll();
		return $this->respond($data, 200);
	}

	public function detail($id = null)
	{
		if (!is_allowed('banner/read')) {
            set_message('toastr_msg', lang('App.permission.not.have'));
            set_message('toastr_type', 'error');
			return $this->respond(array('status' => 201, 'error' => lang('App.permission.not.have')));
        }

		$data = $this->bannerModel->find($id);
		if ($data) {
			return $this->respond($data);
		} else {
			return $this->failNotFound('No Data Found with id ' . $id);
		}
	}

	public function create()
	{
		if (!is_allowed('banner/create')) {
            set_message('toastr_msg', lang('App.permission.not.have'));
            set_message('toastr_type', 'error');
			return $this->respond(array('status' => 201, 'error' => lang('App.permission.not.have')));
        }

		$this->validation->setRule('name', 'Nama', 'required');
		$this->validation->setRule('file_image', 'Gambar', 'required');
		if ($this->request->getPost() && $this->validation->withRequest($this->request)->run()) {
			$save_data = array(
				'name' => $this->request->getPost('name'),
				'sort' => $this->request->getPost('sort'),
				'description' => $this->request->getPost('description'),
				'url' => $this->request->getPost('url'),
				'url_title' => $this->request->getPost('url_title'),
				'url_target' => $this->request->getPost('url_target'),
			);

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
				$this->session->setFlashdata('toastr_msg', 'Banner berhasil ditambah');
				$this->session->setFlashdata('toastr_type', 'success');
				$response = [
					'status'   => 201,
					'error'    => null,
					'messages' => [
						'success' => 'Banner berhasil ditambah'
					]
				];
				return $this->respondCreated($response);
			} else {
				$response = [
					'status'   => 400,
					'error'    => null,
					'messages' => [
						'error' => 'Banner gagal ditambah'
					]
				];
				return $this->fail($response);
			}
		} else {
			$message = $this->validation->listErrors();
			return $this->fail($message, 400);
		}
	}

	public function edit($id = null)
	{
		if (!is_allowed('banner/update')) {
            set_message('toastr_msg', lang('App.permission.not.have'));
            set_message('toastr_type', 'error');
			return $this->respond(array('status' => 201, 'error' => lang('App.permission.not.have')));
        }

		$this->validation->setRule('name', 'Nama', 'required');
		if ($this->request->getPost() && $this->validation->withRequest($this->request)->run()) {
			$update_data = array(
				'name' => $this->request->getPost('name'),
				'sort' => $this->request->getPost('sort'),
				'description' => $this->request->getPost('description'),
				'url' => $this->request->getPost('url'),
				'url_title' => $this->request->getPost('url_title'),
				'url_target' => $this->request->getPost('url_target'),
			);

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
				$update_data['file_image'] = implode(',', $listed_file);
			}

			$bannerUpdate = $this->bannerModel->update($id, $update_data);
			if ($bannerUpdate) {
				add_log('Ubah Banner', 'banner', 'edit', 't_banner', $id);
				$this->session->setFlashdata('toastr_msg', 'Banner berhasil diubah');
				$this->session->setFlashdata('toastr_type', 'success');
				$response = [
					'status'   => 201,
					'error'    => null,
					'messages' => [
						'success' => 'Banner berhasil diubah'
					]
				];
				return $this->respond($response);
			} else {
				return $this->fail('<div class="alert alert-danger fade show" role="alert">Banner gagal diubah</div>', 400);
			}
		} else {
			$message = $this->validation->listErrors();
			return $this->fail($message, 400);
		}
	}

	public function delete($id = null)
	{
		if (!is_allowed('banner/delete')) {
            set_message('toastr_msg', lang('App.permission.not.have'));
            set_message('toastr_type', 'error');
			return $this->respond(array('status' => 201, 'error' => lang('App.permission.not.have')));
        }

		$data = $this->bannerModel->find($id);
		if ($data) {
			$this->bannerModel->delete($id);
			add_log('Hapus Banner', 'banner', 'delete', 't_banner', $id);
			$response = [
				'status'   => 200,
				'error'    => null,
				'messages' => [
					'success' => 'Banner berhasil dihapus'
				]
			];
			return $this->respondDeleted($response);
		} else {
			return $this->failNotFound('Data tidak ditemukan dengan id ' . $id);
		}
	}
}
