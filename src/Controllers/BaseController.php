<?php

namespace hamkamannan\adminigniter\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use CodeIgniter\HTTP\IncomingRequest;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 */

class BaseController extends Controller
{
	/**
	 * An array of helpers to be loaded automatically upon
	 * class instantiation. These helpers will be available
	 * to all other controllers that extend BaseController.
	 *
	 * @var array
	 */
	protected $helpers = ['url', 'text', 'form', 'html', 'auth', 'app'];
	protected $uploadPath;
	protected $uploadFile;
	protected $validation;
	protected $session;
	protected $request;
	protected $config;

	/**
	 * Constructor.
	 *
	 * @param RequestInterface  $request
	 * @param ResponseInterface $response
	 * @param LoggerInterface   $logger
	 */
	public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
	{
		// Do Not Edit This Line
		parent::initController($request, $response, $logger);

		//--------------------------------------------------------------------
		// Preload any models, libraries, etc, here.
		//--------------------------------------------------------------------
		// E.g.: $this->session = \Config\Services::session();

		/**
		 * Adminigniter
		 */
		$this->config = config('Auth');
		$this->session = service('session');
		$this->request = service('request');
		$this->validation = service('validation');

		$this->uploadPath = WRITEPATH . 'uploads/';
		$this->uploadFile = new \CodeIgniter\Files\File($this->uploadPath);
		$this->baseModel = new \App\Models\BaseModel();
	}

	public function do_init()
	{
		$response = [
			'success' => true,
			'data' => '',
			'msg' => "Image has not been loaded successfully"
		];
	}

	public function do_upload()
	{
		$response = [
			'success' => false,
			'data' => '',
			'msg' => "Image has not been uploaded successfully"
		];

		$validated = $this->validate([
			'file' => [
				'uploaded[file]',
				// 'mime_in[file,image/jpg,image/jpeg,image/gif,image/png]',
				'max_size[file,10240]',
			],
		]);

		if ($validated) {
			$file = $this->request->getFile('file');
			$file->move($this->uploadPath);

			$data = [
				'name' =>  $file->getClientName(),
				'type'  => $file->getClientMimeType(),
			];

			$response = [
				'success' => true,
				'data' => $data,
				'msg' => "Image has been uploaded successfully"
			];
		}

		return $this->response->setJSON($response);
	}

	public function do_delete()
	{
		$response = [
			'success' => false,
			'data' => '',
			'msg' => "Image has not been deleted successfully"
		];

		$name = $this->request->getPost('name');
		$path = $this->request->getPost('path');
		$file = $path  . $name;

		if (unlink($file)) {
			$response = [
				'success' => true,
				'data' => '',
				'msg' => "Image has been deleted successfully"
			];
		}

		return $this->response->setJSON($response);
	}

	public function flip()
	{
		$name = $this->request->getVar('name');
		$path = $this->request->getVar('path');
		$file = base_url('uploads/' . $path . '/' . $name);

		$this->data['file'] = $file;
		echo view('layout/flip', $this->data);
	}
}
