<?php

namespace hamkamannan\adminigniter\Modules\Core\Reference\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\Files\File;

class Reference extends ResourceController
{
	use ResponseTrait;
	protected $auth;
    protected $authorize;
    protected $referenceModel;

	protected $validation;
	protected $session;
	function __construct()
	{
		$this->session = session();
		$this->validation = service('validation');
		$this->auth = \Myth\Auth\Config\Services::authentication();
        $this->authorize = \Myth\Auth\Config\Services::authorization();
		
		helper(['app','auth']);

		$this->referenceModel = new \hamkamannan\adminigniter\Modules\Core\Reference\Models\ReferenceModel();
	}

	public function detail($id = null)
	{
		// if (!is_allowed('reference/read')) {
        //     set_message('toastr_msg', lang('App.permission.not.have'));
        //     set_message('toastr_type', 'error');
		// 	return $this->respond(array('status' => 201, 'error' => lang('App.permission.not.have')));
        // }

		$data = $this->referenceModel->find($id);
		if ($data) {
			return $this->respond($data);
		} else {
			return $this->failNotFound('No Data Found with id ' . $id);
		}
	}

	public function create()
	{
		// if (!is_allowed('reference/create')) {
        //     set_message('toastr_msg', lang('App.permission.not.have'));
        //     set_message('toastr_type', 'error');
		// 	return $this->respond(array('status' => 201, 'error' => lang('App.permission.not.have')));
        // }
		$menu_id = $this->request->getPost('menu_id');
		$this->validation->setRule('name', 'Nama Referensi', 'required');
		if ($this->request->getPost() && $this->validation->withRequest($this->request)->run()) {
			$form_slug = url_title($this->request->getPost('name'), '-', TRUE);
			$save_data = array(
				'name' => $this->request->getPost('name'),
				'slug' => $form_slug,
				'sort' => $this->request->getPost('sort'),
				'description' => $this->request->getPost('description'),
				'menu_id' => $menu_id,
			);

			$newReferenceId = $this->referenceModel->insert($save_data);
			if ($newReferenceId) {
				$this->session->setFlashdata('toastr_msg', 'Referensi berhasil ditambah');
				$this->session->setFlashdata('toastr_type', 'success');
				$response = [
					'status'   => 201,
					'error'    => null,
					'messages' => [
						'success' => 'Referensi berhasil ditambah'
					]
				];
				return $this->respondCreated($response);
			} else {
				$response = [
					'status'   => 400,
					'error'    => null,
					'messages' => [
						'error' => 'Referensi gagal ditambah'
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
		// if (!is_allowed('reference/update')) {
        //     set_message('toastr_msg', lang('App.permission.not.have'));
        //     set_message('toastr_type', 'error');
		// 	return $this->respond(array('status' => 201, 'error' => lang('App.permission.not.have')));
        // }

		$this->validation->setRule('name', 'Nama', 'required');
		if ($this->request->getPost() && $this->validation->withRequest($this->request)->run()) {
			$update_data = array(
				'name' => $this->request->getPost('name'),
				'sort' => $this->request->getPost('sort'),
				'description' => $this->request->getPost('description'),
			);

			if(!empty($this->request->getPost('slug'))){
				$update_data['slug'] = $this->request->getPost('slug');
			}

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

			$referenceUpdate = $this->referenceModel->update($id, $update_data);
			if ($referenceUpdate) {
				$this->session->setFlashdata('toastr_msg', 'Reference berhasil diubah');
				$this->session->setFlashdata('toastr_type', 'success');
				$response = [
					'status'   => 201,
					'error'    => null,
					'messages' => [
						'success' => 'Reference berhasil diubah'
					]
				];
				return $this->respond($response);
			} else {
				return $this->fail('<div class="alert alert-danger fade show" role="alert">Reference gagal diubah</div>', 400);
			}
		} else {
			$message = $this->validation->listErrors();
			return $this->fail($message, 400);
		}
	}

	public function list($slug)
	{
		// if (!is_allowed('reference/read')) {
        //     set_message('toastr_msg', lang('App.permission.not.have'));
        //     set_message('toastr_type', 'error');
		// 	return $this->respond(array('status' => 201, 'error' => lang('App.permission.not.have')));
        // }

		$data = $this->referenceModel
			->select('c_references.*')
			->join('c_menus','c_menus.id = c_references.menu_id', 'inner')
			->where('c_menus.slug',$slug)
			->find_all('c_references.sort', 'asc');

		if ($data) {
			return $this->respond($data);
		} else {
			return $this->failNotFound('No Data Found with slug ' . $slug);
		}
	}
}
