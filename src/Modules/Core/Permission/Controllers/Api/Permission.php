<?php

namespace hamkamannan\adminigniter\Modules\Core\Permission\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\Files\File;

class Permission extends ResourceController
{
	use ResponseTrait;
	protected $auth;
    protected $authorize;
	protected $groupModel;
	protected $permissionModel;
	protected $validation;
	protected $session;
	function __construct()
	{
		$this->session = session();
		$this->validation = service('validation');
		$this->auth = \Myth\Auth\Config\Services::authentication();
        $this->authorize = \Myth\Auth\Config\Services::authorization();
		
		helper(['app','auth']);

		$this->groupModel = new \hamkamannan\adminigniter\Modules\Core\Group\Models\GroupModel();
		$this->permissionModel = new \hamkamannan\adminigniter\Modules\Core\Permission\Models\PermissionModel();
	}

	public function detail($id = null)
	{
		$data = $this->permissionModel->find($id);
		if ($data) {
			return $this->respond($data);
		} else {
			return $this->failNotFound('No Data Found with id ' . $id);
		}
	}
	
	public function create()
	{
		$this->validation->setRule('name', 'Nama Permission', 'required');
		if ($this->request->getPost() && $this->validation->withRequest($this->request)->run()) {
			$newPermissionId = $this->authorize->createPermission($this->request->getPost('name'), $this->request->getPost('description'));
			if ($newPermissionId) {
				$this->session->setFlashdata('toastr_msg', lang('Permission.info.success.create'));
				$this->session->setFlashdata('toastr_type', 'success');
				$response = [
					'status'   => 200,
					'error'    => null,
					'messages' => [
						'success' => lang('Permission.info.success.create')
					]
				];
				return $this->respondCreated($response);
			} else {
				$response = [
					'status'   => 400,
					'error'    => null,
					'messages' => [
						'error' => lang('Permission.info.fail.create')
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
		$this->validation->setRule('name', 'Nama Permission', 'required');
		if ($this->request->getPost() && $this->validation->withRequest($this->request)->run()) {
			$permissionUpdate = $this->authorize->updatePermission($id, $this->request->getPost('name'), $this->request->getPost('description'));
			if ($permissionUpdate) {
				$this->session->setFlashdata('toastr_msg', 'Permission berhasil disimpan');
				$this->session->setFlashdata('toastr_type', 'success');
				$response = [
					'status'   => 201,
					'error'    => null,
					'messages' => [
						'success' => 'Permission berhasil disimpan'
					]
				];
				return $this->respond($response);
			} else {
				return $this->fail('<div class="alert alert-danger fade show" role="alert">Permission gagal disimpan</div>', 400);
			}
		} else {
			$message = $this->validation->listErrors();
			return $this->fail($message, 400);
		}
	}

	public function delete($id = null)
	{
		$data = $this->permissionModel->find($id);
		if ($data) {
			$this->authorize->deletePermission($id);
			$response = [
				'status'   => 200,
				'error'    => null,
				'messages' => [
					'success' => lang('Permission.info.success.delete')
				]
			];
			return $this->respondDeleted($response);
		} else {
			return $this->failNotFound('No Data Found with id ' . $id);
		}
	}
}
