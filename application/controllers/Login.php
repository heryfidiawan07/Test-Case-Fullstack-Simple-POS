<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->library('form_validation');

		$this->load->model('AuthModel');
        if($this->AuthModel->auth()->check) {
			// redirect('dashboard');
			$url = $this->AuthModel->auth()->menus[0]->url[0];
			redirect($url);
		}
	}	

	public function index() {
		$data['title'] = 'LOGIN';
		$this->load->view('auth/login', $data);
	}

	public function store() {
		try {
			$this->form_validation->set_rules(
				'email', 'email', 'trim|required|valid_email'
			);
			$this->form_validation->set_rules(
				'password', 'password', 'trim|required'
			);

			if ($this->form_validation->run() == FALSE) {
				throw new Exception(validation_errors());
			}

			$email    = $this->input->post('email');
			$password = $this->input->post('password');
			$user     = $this->db->get_where('users', ['email' => $email])->row();
			if(!$user) {
				throw new Exception('User not found !');
			}

			if (!password_verify($password, $user->password)) {
				throw new Exception('Email / password invalid !');
			}

			$token = uuid();
			$this->db->update('users', ['token'=>$token], ['id'=>$user->id]);
			$this->session->set_userdata(['token'=>$token]);

			$url = $this->AuthModel->auth()->menus[0]->url[0];
			redirect($url);
		} catch (\Throwable $th) {
			$this->session->set_flashdata(
				'message', '<div class="d-block text-danger font-weight-bold">'.$th->getMessage().'</div>'
			);
			redirect('login');
		}
	}
}