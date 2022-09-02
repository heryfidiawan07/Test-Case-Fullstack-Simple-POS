<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{
    private $auth;

    public function __construct()
    {
        parent::__construct();

        $this->load->model('AuthModel');
        $this->auth = $this->AuthModel->auth();
        // echo json_encode($this->auth);die;
    }

    public function index()
    {
        if(! can('dashboard')) {
            show_404();
        }

        $data['auth'] = $this->auth;
        $data['title'] = 'Dashboard';

        // $this->load->view('dashboard/index', $data);
        $this->twig->display('dashboard/index', $data);
    }
}