<?php

namespace hamkamannan\adminigniter\Modules\Core\Group\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\Files\File;

class Group extends ResourceController
{
	use ResponseTrait;
	protected $auth;
    protected $authorize;
	protected $groupModel;
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
		$this->validation = \Config\Services::validation();
	}
	public function index()
	{
		$data = $this->groupModel->findAll();
		return $this->respond($data, 200);
	}

	public function detail($id = null)
	{
		$data = $this->groupModel->find($id);
		if ($data) {
			return $this->respond($data);
		} else {
			return $this->failNotFound('No Data Found with id ' . $id);
		}
	}
	
	public function create()
	{
		$this->validation->setRule('name', 'Nama Group', 'required');
		if ($this->request->getPost() && $this->validation->withRequest($this->request)->run()) {
			$newGroupId = $this->authorize->createGroup($this->request->getPost('name'), $this->request->getPost('description'));
			if ($newGroupId) {
				add_log('Tambah Group', 'param', 'create', 'auth_groups', $newGroupId);
				$this->session->setFlashdata('toastr_msg', lang('Group.info.success.create'));
				$this->session->setFlashdata('toastr_type', 'success');
				$response = [
					'status'   => 200,
					'error'    => null,
					'messages' => [
						'success' => lang('Group.info.success.create')
					]
				];
				return $this->respondCreated($response);
			} else {
				$response = [
					'status'   => 400,
					'error'    => null,
					'messages' => [
						'error' => lang('Group.info.fail.create')
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
		$this->validation->setRule('name', 'Nama Group', 'required');
		if ($this->request->getPost() && $this->validation->withRequest($this->request)->run()) {
			$groupUpdate = $this->authorize->updateGroup($id, $this->request->getPost('name'), $this->request->getPost('description'));
			if ($groupUpdate) {
				add_log('Ubah Group', 'param', 'edit', 'auth_groups', $id);
				$this->session->setFlashdata('toastr_msg', 'Group berhasil disimpan');
				$this->session->setFlashdata('toastr_type', 'success');
				$response = [
					'status'   => 201,
					'error'    => null,
					'messages' => [
						'success' => 'Group berhasil disimpan'
					]
				];
				return $this->respond($response);
			} else {
				return $this->fail('<div class="alert alert-danger fade show" role="alert">Group gagal disimpan</div>', 400);
			}
		} else {
			$message = $this->validation->listErrors();
			return $this->fail($message, 400);
		}
	}

	public function delete($id = null)
	{
		$data = $this->groupModel->find($id);
		if ($data) {
			$this->authorize->deleteGroup($id);
			$response = [
				'status'   => 200,
				'error'    => null,
				'messages' => [
					'success' => lang('Group.info.success.delete')
				]
			];
			return $this->respondDeleted($response);
		} else {
			return $this->failNotFound('No Data Found with id ' . $id);
		}
	}
}
