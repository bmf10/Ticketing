<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$is_login = $this->session->userdata('is_logged');
		if ($is_login) {
			redirect('admin');
		}
	}

	public function index()
	{
		$this->load->view('admin/login');
	}

	public function execute()
	{
		$email = $this->input->post('email');
		$password = $this->input->post('password');
		$result = $this->db->get_where('users', ['email' => $email]);

		if ($result->num_rows() === 0) {
			$this->session->set_flashdata('message', "<script>$(document).ready(function() { toastr.error('Email not found');});</script>");
			redirect('admin/auth');
		} else {
			if (password_verify($password, $result->row()->password) === true) {
				$data_session = [
					'id' => $result->row()->id,
					'role' => $result->row()->role,
					'is_logged' => true,
				];

				$this->session->set_userdata($data_session);

				$this->session->set_flashdata('message', "<script>$(document).ready(function() { toastr.success('Login Successfull');});</script>");
				redirect('admin');
			} else {
				$this->session->set_flashdata('message', "<script>$(document).ready(function() { toastr.error('Wrong Password');});</script>");
				redirect('admin/auth');
			}
		}
	}
}
