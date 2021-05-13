<?php

namespace hamkamannan\adminigniter\Modules\Core\Param\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\Files\File;

class Param extends ResourceController
{
	use ResponseTrait;
	protected $paramModel;
	protected $validation;
	protected $session;
	function __construct()
	{
		$this->session = session();
		$this->validation = service('validation');
		$this->auth = \Myth\Auth\Config\Services::authentication();
        $this->authorize = \Myth\Auth\Config\Services::authorization();
		
		helper(['app','auth']);

		$this->paramModel = new \hamkamannan\adminigniter\Modules\Core\Param\Models\ParamModel();
	}

	public function create()
	{
		$this->validation->setRule('name', 'Nama Param', 'trim');
		$this->validation->setRule('value', 'Nilai Param', 'trim');
		if ($this->request->getPost()) {
			if ($this->validation->withRequest($this->request)->run()) {
				$name = $this->request->getPost('name');
				$value = $this->request->getPost('value');

				$param = $this->paramModel->where('name', $name)->first();

				if ($param) {
					$update_data = array(
						'name' => $name,
						'value' => $value,
					);

					$paramSave = $this->paramModel->update($param->id, $update_data);
				} else {
					$save_data = array(
						'name' => $name,
						'value' => $value,
					);

					$paramSave = $this->paramModel->insert($save_data);
				}

				if ($paramSave) {
					$this->session->setFlashdata('toastr_msg', 'Param berhasil disimpan');
					$this->session->setFlashdata('toastr_type', 'success');
					$response = [
						'status'   => 200,
						'error'    => null,
						'messages' => [
							'success' => 'Param brhasil disimpan'
						]
					];
					return $this->respondUpdated($response);
				} else {
					$this->session->setFlashdata('toastr_msg', 'Param gagal disimpan');
					$this->session->setFlashdata('toastr_type', 'warning');
					$response = [
						'status'   => 200,
						'error'    => null,
						'messages' => [
							'success' => 'Param gagal disimpan'
						]
					];
					return $this->respondUpdated($response);
				}
			} else {
				$message = $this->validation->listErrors();
				return $this->fail($message, 400);
			}
		}
	}

	public function setting()
	{
		$this->validation->setRule('status', 'Status', 'trim');
		if ($this->request->getPost()) {
			if ($this->validation->withRequest($this->request)->run()) {
				$name = $this->request->getPost('name');
				$param = $this->paramModel->where('name', $name)->first();

				$update_data = array(
					'name' => $name,
					'value' => $this->request->getPost('status'),
				);

				$paramUpdate = $this->paramModel->update($param->id, $update_data);
				if ($paramUpdate) {
					$this->session->setFlashdata('toastr_msg', 'Param berhasil diupdate');
					$this->session->setFlashdata('toastr_type', 'success');
					$response = [
						'status'   => 200,
						'error'    => null,
						'messages' => [
							'success' => 'Param brhasil diupdate'
						]
					];
					return $this->respondUpdated($response);
				} else {
					$this->session->setFlashdata('toastr_msg', 'Param gagal diupdate');
					$this->session->setFlashdata('toastr_type', 'warning');
					$response = [
						'status'   => 200,
						'error'    => null,
						'messages' => [
							'success' => 'Param gagal diupdate'
						]
					];
					return $this->respondUpdated($response);
				}
			} else {
				$message = $this->validation->listErrors();
				return $this->fail($message, 400);
			}
		}
	}
}
