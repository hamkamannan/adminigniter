<?php

namespace hamkamannan\adminigniter\Modules\Core\User\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\Files\File;
use Myth\Auth\Entities\User as MythUser;

class User extends ResourceController
{
	use ResponseTrait;
	protected $auth;
	protected $authorize;
	protected $userModel;
	protected $groupModel;
	protected $validation;
	protected $session;
	protected $config;
	protected $uploadPath;
	function __construct()
	{
		$this->session = session();
		$this->validation = service('validation');
		$this->config = config('Auth');
		$this->auth = \Myth\Auth\Config\Services::authentication();
        $this->authorize = \Myth\Auth\Config\Services::authorization();
		
		helper(['app','auth']);

		$this->userModel = new \hamkamannan\adminigniter\Modules\Core\User\Models\UserModel();
		$this->groupModel = new \hamkamannan\adminigniter\Modules\Core\Group\Models\GroupModel();
		$this->uploadPath = WRITEPATH . 'uploads/';
	}
	public function view($id = null)
	{
		$data = $this->userModel->find($id);
		if ($data) {
			return $this->respond($data);
		} else {
			return $this->failNotFound('No Data Found with id ' . $id);
		}
	}
	public function create()
	{
		$users = model('UserModel');

		// Validate here first, since some things,
		// like the password, can only be validated properly here.
		$rules = [
			'username'  	=> [
				'label' => 'Username',
				'rules' => 'required|alpha_numeric_space|min_length[3]|is_unique[users.username]',
			],
			'email'			=> [
				'label' => 'Email',
				'rules' => 'required|valid_email|is_unique[users.email]',
			],
			// 'first_name'	 	=> [
			// 	'label' => 'Nama Depan',
			// 	'rules' => 'required',
			// ],
			'password'	 	=> [
				'label' => 'Password',
				'rules' => 'required',
			],
			'pass_confirm' 	=> [
				'label' => 'Konfirmasi Password',
				'rules' => 'required|matches[password]',
			]
		];

		if (!$this->validate($rules)) {
			$message = $this->validation->listErrors();
			return $this->fail($message, 400);
		}

		// Save the user
		$allowedPostFields = array_merge(['password'], $this->config->validFields, $this->config->personalFields);
		$user = new MythUser($this->request->getPost($allowedPostFields));

		$this->config->requireActivation !== false ? $user->generateActivateHash() : $user->activate();

		// Ensure default group gets assigned if set
		if (!empty($this->config->defaultUserGroup)) {
			$users = $users->withGroup($this->config->defaultUserGroup);
		}

		if (!$users->save($user)) {
			set_message('message', $this->session->getFlashdata('message'));
			return $this->fail('<div class="alert alert-danger fade show" role="alert">User gagal disimpan</div>', 400);
		}

		if ($this->config->requireActivation !== false) {
			$activator = service('activator');
			$sent = $activator->send($user);

			if (!$sent) {
				set_message('message', $this->session->getFlashdata('message'));
				return $this->fail('<div class="alert alert-danger fade show" role="alert">'.$activator->error() ?? lang('Auth.unknownError').'</div>', 400);
			}

			// Success!
			$response = [
				'status'   => 201,
				'error'    => null,
				'messages' => [
					'success' => lang('Auth.activationSuccess')
				]
			];
			return $this->respond($response);
		}

		add_log('Tambah User', 'user', 'create', 'auth_users', '');
		// Success!
		$response = [
			'status'   => 201,
			'error'    => null,
			'messages' => [
				'success' => lang('Auth.registerSuccess')
			]
		];
		return $this->respond($response);
	}

	public function edit($id = null)
	{
		$this->validation->setRule('username', 'Username', 'required');
		$this->validation->setRule('email', 'Email', 'required');
		if ($this->request->getPost('password')) {
			$this->validation->setRule('password', 'Password', 'required|min_length[' . $this->config->minimumPasswordLength . ']');
			$this->validation->setRule('pass_confirm', 'Konfirmasi Password', 'required|matches[password]');
		}

		if (is_admin()) {
			$this->validation->setRule('groups', 'Group', 'required');
		}

		if ($this->request->getPost() && $this->validation->withRequest($this->request)->run()) {
			$update_data = array(
				'first_name' => $this->request->getPost('first_name'),
				'last_name' => $this->request->getPost('last_name'),
				'phone' => $this->request->getPost('phone'),
				'unit' => $this->request->getPost('unit'),
				'company' => $this->request->getPost('company'),
				'address' => $this->request->getPost('address'),
			);

			if ($this->request->getPost('password')) {
				if (
					(defined('PASSWORD_ARGON2I') && $this->config->hashAlgorithm == PASSWORD_ARGON2I)
						||
					(defined('PASSWORD_ARGON2ID') && $this->config->hashAlgorithm == PASSWORD_ARGON2ID)
					)
				{
					$hashOptions = [
						'memory_cost' => $this->config->hashMemoryCost,
						'time_cost'   => $this->config->hashTimeCost,
						'threads'     => $this->config->hashThreads
					];
				}
				else
				{
					$hashOptions = [
						'cost' => $this->config->hashCost
					];
				}
		
				$update_data['password_hash'] = password_hash(
					base64_encode(
						hash('sha384', $this->request->getPost('password'), true)
					),
					$this->config->hashAlgorithm,
					$hashOptions
				);
		
				$update_data['reset_hash'] = null;
				$update_data['reset_at'] = null;
				$update_data['reset_expires'] = null;
			}

			// $files = (array)$this->request->getPost('file_image');
			// if (count($files)) {
			// 	$listed_file = array();
			// 	foreach ($files as $uuid => $name) {
			// 		if (file_exists($this->modulePathProfile . $name)) {
			// 			$listed_file[] = $name;
			// 		} else {
			// 			if (file_exists($this->uploadPath . $name)) {
			// 				$file = new File($this->uploadPath . $name);
			// 				$newFileName = $file->getRandomName();
			// 				$file->move($this->modulePathProfile, $newFileName);
			// 				$listed_file[] = $newFileName;
			// 			}
			// 		}
			// 	}
			// 	$update_data['file_image'] = implode(',', $listed_file);
			// }

			// dd($update_data);
			$userUpdate = $this->userModel->update($id, $update_data);
			if ($userUpdate) {
				add_log('Ubah User', 'user', 'edit', 'auth_users', $id);
				if (is_admin()) {
					$groups = $this->authorize->groups();
					foreach ($groups as $group) {
						$this->authorize->removeUserFromGroup($id, $group->id);
					}

					$group_ids = $this->request->getPost('groups');
					foreach ($group_ids as $group_id) {
						$this->authorize->addUserToGroup($id, $group_id);
					}
				}

				$this->session->setFlashdata('toastr_msg', 'Profil User berhasil disimpan');
				$this->session->setFlashdata('toastr_type', 'success');
				$response = [
					'status'   => 201,
					'error'    => null,
					'messages' => [
						'success' => 'Profil User berhasil disimpan'
					]
				];
				return $this->respond($response);
			} else {
				return $this->fail('<div class="alert alert-danger fade show" role="alert">Profil User gagal disimpan</div>', 400);
			}
		} else {
			$message = $this->validation->listErrors();
			return $this->fail($message, 400);
		}
	}
}
