<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Report extends CI_Controller
{
    private $auth;

    public function __construct()
    {
        parent::__construct();

        $this->load->model(['AuthModel', 'ReportModel']);
        $this->auth = $this->AuthModel->auth();
        // echo json_encode($this->auth);die;
    }

    public function index()
    {
        if(! can('report')) {
            show_404();
        }

        $data['auth'] = $this->auth;
        $data['title'] = 'Report';

        $this->load->view('report/index', $data);
    }

    public function purchase()
    {
        try {
            $data = $this->ReportModel->queryPurchase();
            echo json_encode(['status'=>true, 'data'=>$data]);
        } catch (\Throwable $th) {
            echo json_encode(['status'=>false, 'message'=>$th->getMessage()]);
        }
    }

    public function sale()
    {
        try {
            $data = $this->ReportModel->querySale();
            echo json_encode(['status'=>true, 'data'=>$data]);
        } catch (\Throwable $th) {
            echo json_encode(['status'=>false, 'message'=>$th->getMessage()]);
        }
    }
}