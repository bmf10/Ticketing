<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		is_admin();
	}

	public function index()
	{
		$id = $this->session->userdata('id');

		$data['title'] = 'Dashboard';
		$data['user'] = $this->db->get_where('users', ['id' => $id])->row();
		$this->template->load('/admin/base', '/admin/dashboard', $data);
	}

	public function admin($id = '')
	{
		if ($this->session->userdata('role') != 3) {
			redirect('admin');
		}
		if ($this->input->post()) {
			if ($id == '') {
				$this->form_validation->set_rules('phone', 'Phone', 'required|trim|is_unique[users.phone]');
				$this->form_validation->set_rules('email', 'Email', 'required|valid_email|trim|is_unique[users.email]');

				if ($this->form_validation->run() === FALSE) {
					$data['admin'] = '';
					$data['title'] = 'User Admin';
					$this->template->load('/admin/base', '/admin/admin', $data);
				} else {
					$post = $this->input->post();
					$post['password'] = password_hash($this->input->post('password'), PASSWORD_DEFAULT);
					$post['role'] = 2;
					$post['is_verified'] = 1;

					$this->db->insert('users', $post);
					$this->session->set_flashdata('message', "<script>$(document).ready(function() { toastr.success('Account created successfull');});</script>");
					redirect('admin');
				}
			} else {
				$user = $this->db->get_where('users', ['id' => $id])->row();
				if ($user->email != $this->input->post('email')) {
					$this->form_validation->set_rules('email', 'Email', 'required|valid_email|trim|is_unique[users.email]');
				} else {
					$this->form_validation->set_rules('email', 'email', 'required');
				}
				if ($user->phone != $this->input->post('phone')) {
					$this->form_validation->set_rules('phone', 'Phone', 'required|trim|is_unique[users.phone]');
				} else {
					$this->form_validation->set_rules('phone', 'phone', 'required');
				}

				if ($this->form_validation->run() === FALSE) {
					$data['admin'] = $this->db->get_where('users', ['id' => $id])->row();
					$data['title'] = 'User Admin';
					$this->template->load('/admin/base', '/admin/admin', $data);
				} else {
					$post = $this->input->post();

					$this->db->update('users', $post, ['id' => $id]);
					$this->session->set_flashdata('message', "<script>$(document).ready(function() { toastr.success('Account updated successfull');});</script>");
					redirect('admin');
				}
			}
		} else {
			if ($id) {
				$data['admin'] = $this->db->get_where('users', ['id' => $id])->row();
			} else {
				$data['admin'] = '';
			}

			$data['title'] = 'User Admin';
			$this->template->load('/admin/base', '/admin/admin', $data);
		}
	}

	public function profile()
	{
		$id = $this->session->userdata('id');
		if ($this->input->post()) {
			$user = $this->db->get_where('users', ['id' => $id])->row();

			if ($user->email != $this->input->post('email')) {
				$this->form_validation->set_rules('email', 'Email', 'required|valid_email|trim|is_unique[users.email]');
			} else {
				$this->form_validation->set_rules('email', 'email', 'required');
			}

			if ($user->phone != $this->input->post('phone')) {
				$this->form_validation->set_rules('phone', 'Phone', 'required|trim|is_unique[users.phone]');
			} else {
				$this->form_validation->set_rules('phone', 'phone', 'required');
			}

			if ($this->form_validation->run() === FALSE) {
				$data['user'] = $this->db->get_where('users', ['id' => $id])->row();
				$data['title'] = 'Edit Profile';
				$this->template->load('/admin/base', '/admin/profile', $data);
			} else {
				$post = $this->input->post();

				$this->db->update('users', $post, ['id' => $id]);
				$this->session->set_flashdata('message', "<script>$(document).ready(function() { toastr.success('Account updated successfull');});</script>");
				redirect('admin');
			}
		} else {
			$data['user'] = $this->db->get_where('users', ['id' => $id])->row();
			$data['title'] = 'Edit Profile';
			$this->template->load('/admin/base', '/admin/profile', $data);
		}
	}

	public function logout()
	{
		$this->session->sess_destroy();
		redirect('admin/auth');
	}
}
