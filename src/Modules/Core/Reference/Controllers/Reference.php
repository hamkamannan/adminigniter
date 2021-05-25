<?php

namespace hamkamannan\adminigniter\Modules\Core\Reference\Controllers;

use \CodeIgniter\Files\File;

class Reference extends \hamkamannan\adminigniter\Controllers\BaseController
{
    protected $auth;
    protected $authorize;
    protected $referenceModel;
    
    function __construct()
    {
        $this->referenceModel = new \hamkamannan\adminigniter\Modules\Core\Reference\Models\ReferenceModel();

        $this->auth = \Myth\Auth\Config\Services::authentication();
        $this->authorize = \Myth\Auth\Config\Services::authorization();
        $this->session = service('session');

        if (! $this->auth->check() )
		{
			$this->session->set('redirect_url', current_url() );
			return redirect()->route('login');
		} 
    }
    public function index()
    {
        $slug = $this->request->getVar('slug');

        if (!is_allowed('reference/access')) {
            set_message('toastr_msg', lang('App.permission.not.have'));
            set_message('toastr_type', 'error');
            return redirect()->to('/dashboard');
        }

        $query = $this->referenceModel
            ->select('c_references.*')
            ->select('c_menus.name as category, c_menus.controller as code')
            ->join('c_menus','c_menus.id = c_references.menu_id', 'left');

        if(!empty($slug)){
            $query->where('c_menus.slug', $slug);
        }
        $references = $query->findAll();

        $this->data['title'] = 'Referensi';
        $this->data['message'] = $this->validation->getErrors() ? $this->validation->listErrors() : $this->session->getFlashdata('message');
        $this->data['references'] = $references;
        echo view('hamkamannan\adminigniter\Modules\Core\Reference\Views\list', $this->data);
    }

    public function delete(int $id = 0)
    {
        $slug = $this->request->getVar('slug') ?? '';

        if (!is_allowed('reference/delete')) {
            set_message('toastr_msg', lang('App.permission.not.have'));
            set_message('toastr_type', 'error');
            return redirect()->to('/dashboard');
        }

        if (!$id) {
            set_message('toastr_msg', 'Sorry you have to provide parameter (id)');
            set_message('toastr_type', 'error');
            return redirect()->to('/reference');
        }
        $referenceDelete = $this->referenceModel->delete($id);
        if ($referenceDelete) {
            add_log('Hapus Reference', 'reference', 'delete', 't_reference', $id);
            set_message('toastr_msg', 'Reference berhasil dihapus');
            set_message('toastr_type', 'success');
            return redirect()->to('/reference?slug='.$slug);
        } else {
            set_message('toastr_msg', 'Reference gagal dihapus');
            set_message('toastr_type', 'warning');
            set_message('message', 'Reference gagal dihapus');
            return redirect()->to('/reference?slug='.$slug);
        }
    }

    public function enable($id = null)
    {
        if (!is_allowed('reference/enable')) {
            set_message('toastr_msg', lang('App.permission.not.have'));
            set_message('toastr_type', 'error');
            return redirect()->to('/dashboard');
        }

        $referenceUpdate = $this->referenceModel->update($id, array('active' => 1));

        if ($referenceUpdate) {
            set_message('toastr_msg', 'Reference berhasil diaktifkan');
            set_message('toastr_type', 'success');
        } else {
            set_message('toastr_msg', 'Reference gagal diaktifkan');
            set_message('toastr_type', 'warning');
        }
        return redirect()->to('/reference');
    }

    public function disable($id = null )
    {
        if (!is_allowed('reference/disable')) {
            set_message('toastr_msg', lang('App.permission.not.have'));
            set_message('toastr_type', 'error');
            return redirect()->to('/dashboard');
        }

        $referenceUpdate = $this->referenceModel->update($id, array('active' => 0));

        if ($referenceUpdate) {
            set_message('toastr_msg', 'Reference berhasil dinonaktifkan');
            set_message('toastr_type', 'success');
        } else {
            set_message('toastr_msg', 'Reference gagal dinonaktifkan');
            set_message('toastr_type', 'warning');
        }
        return redirect()->to('/reference');
    }
}
