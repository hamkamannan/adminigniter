<?php

namespace hamkamannan\adminigniter\Modules\Core\Access\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\Files\File;

class Access extends ResourceController
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
		$this->validation = \Config\Services::validation();
	}

	public function add_to_group($group_id)
	{
		$response = false;
		$permissions = $this->permissionModel->findAll();
		foreach ($permissions as $permission){
			$this->authorize->removePermissionFromGroup($permission->name, $group_id);
		}
		
		$access = '';
		$new_permissions = $this->request->getPost('permissions');
		foreach($new_permissions as $permission){
			$exist_permission = $this->authorize->permission($permission);
			if(empty($exist_permission)){
				$this->authorize->createPermission($permission, '');
			}

			$access .= $permission. ',';
			$this->authorize->addPermissionToGroup($permission, $group_id);
		}
		
		add_log('Tambah Access<br>Group ID: '.$group_id.'<br>Access: '.$access,'access', 'create', 'auth_groups_permission', '');
		$this->session->setFlashdata('toastr_msg', 'Access berhasil diupdate');
		$this->session->setFlashdata('toastr_type', 'success');
		$response = [
			'status'   => 201,
			'error'    => null,
			'messages' => [
				'success' => 'Access berhasil diupdate'
			]
		];
		return $this->respondCreated($response);

	}
}
