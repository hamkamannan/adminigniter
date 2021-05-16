<?php

namespace App\Adminigniter\Modules\Backend\Report\Controllers;

use PhpOffice\PhpSpreadsheet\Helper\Sample;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Report extends \hamkamannan\adminigniter\Controllers\BaseController
{
    protected $auth;
    protected $authorize;
    protected $visitorModel;
    protected $logModel;

    function __construct()
    {
        $this->visitorModel = new \hamkamannan\adminigniter\Models\VisitorModel();
        $this->logModel = new \hamkamannan\adminigniter\Models\LogModel();
        
        $this->auth = \Myth\Auth\Config\Services::authentication();
        $this->authorize = \Myth\Auth\Config\Services::authorization();

        if (! $this->auth->check() )
		{
            $this->session = service('session');
			$this->session->set('redirect_url', current_url() );
			return redirect()->route('login');
		} else {
			return redirect()->route('dashboard');
		}
    }
    public function index()
    {
        echo "Report";
    }

    public function logs()
    {
        if (!is_allowed('report/access')) {
            set_message('toastr_msg', lang('App.permission.not.have'));
            set_message('toastr_type', 'error');
            return redirect()->to('/dashboard');
        }

        $from_date = $this->request->getVar('from_date');
        $to_date = $this->request->getVar('to_date');

        $this->baseModel->setTable('c_logs');
        $query = $this->baseModel
            ->select('c_logs.*')
            ->select('users.username')
            ->join('users','users.id=c_logs.created_by','left');

        if (!empty($from_date)) {
            $query->where('c_logs.created_at >=', $from_date);
        }

        if (!empty($to_date)) {
            $query->where('c_logs.created_at <=', $to_date);
        }

        $logs = $query->find_all('c_logs.created_at','desc');
        $this->data['logs'] = $logs;

        $this->data['title'] = 'Laporan - Audit Log';
        echo view('App\Adminigniter\Modules\Backend\Report\Views\logs', $this->data);
    }

    public function visitors()
    {
        if (!is_allowed('report/access')) {
            set_message('toastr_msg', lang('App.permission.not.have'));
            set_message('toastr_type', 'error');
            return redirect()->to('/dashboard');
        }

        $from_date = $this->request->getVar('from_date');
        $to_date = $this->request->getVar('to_date');

        $this->baseModel->setTable('c_visitors');
        $query = $this->baseModel->select('c_visitors.*');

        if (!empty($from_date)) {
            $query->where('timestamp >=', $from_date);
        }

        if (!empty($to_date)) {
            $query->where('timestamp <=', $to_date);
        }

        $visitors = $query->find_all('timestamp','desc');
        $this->data['visitors'] = $visitors;

        $this->data['title'] = 'Laporan - Visitor';
        echo view('App\Adminigniter\Modules\Backend\Report\Views\visitors', $this->data);
    }

    public function visitors_export(){
        if (!$this->auth->loggedIn()) {
            return redirect()->to('/auth/login');
        } else {
            $from_date = $this->request->getVar('from_date');
            $to_date = $this->request->getVar('to_date');

            $this->baseModel->setTable('c_visitors');
            $query = $this->baseModel->select('c_visitors.*');

            if (!empty($from_date)) {
                $query->where('timestamp >=', $from_date);
            }

            if (!empty($to_date)) {
                $query->where('timestamp <=', $to_date);
            }

            $visitors = $query->find_all('timestamp','desc');

            $spreadsheet = new Spreadsheet();
            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('A1', 'No')
                ->setCellValue('B1', 'Tanggal Kunjungan')
                ->setCellValue('C1', 'Alamat IP')
                ->setCellValue('D1', 'Jumlah Kunjungan')
                ->setCellValue('E1', 'Kunjungan terakhir');

            $col = 2;
            $no = 1;
            foreach ($visitors as $row) {
                $spreadsheet->setActiveSheetIndex(0)
                    ->setCellValue('A' . $col, $no)
                    ->setCellValue('B' . $col, $row->timestamp)
                    ->setCellValue('C' . $col, $row->ip_address)
                    ->setCellValue('D' . $col, $row->hits)
                    ->setCellValue('E' . $col, $row->updated_at);
                $col++;
                $no++;
            }

            $writer = new Xlsx($spreadsheet);
            $subject = 'Laporan Kujungan';
            $filename = ucwords($subject) . '-' . date('Y-m-d');

            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
            header('Cache-Control: max-age=0');

            $writer->save('php://output');
        }
    }
}
