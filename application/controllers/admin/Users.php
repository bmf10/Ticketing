<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Users extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		is_admin();
	}

	public function index()
	{
		$data['title'] = 'Users';
		$data['users'] = $this->db->get('users')->result();
		$this->template->load('/admin/base', '/admin/users', $data);
	}

	public function edit($id)
	{
		if (!$id) {
			redirect('admin/users');
		}

		if ($this->input->post()) {
			$user = $this->db->get_where('users', ['id' => $id])->row();
			if ($user->email != $this->input->post('email')) {
				$this->form_validation->set_rules('email', 'Email', 'required|valid_email|trim|is_unique[users.email]');
			} else {
				$this->form_validation->set_rules('phone', 'Phone', 'required');
			}
			if ($user->phone != $this->input->post('phone')) {
				$this->form_validation->set_rules('phone', 'Phone', 'required|trim|is_unique[users.phone]');
			} else {
				$this->form_validation->set_rules('email', 'Email', 'required');
			}

			if ($this->form_validation->run() === FALSE) {
				$data['title'] = 'Users';
				$data['user'] = $this->db->get_where('users', ['id' => $id])->row();
				$this->template->load('/admin/base', '/admin/user_edit', $data);
			} else {
				$post = $this->input->post();
				if ($post['password'] != '') {
					$post['password'] = password_hash($this->input->post('password'), PASSWORD_DEFAULT);
					$this->db->update('users', $post, ['id' => $id]);
					$this->session->set_flashdata('message', "<script>$(document).ready(function() { toastr.success('Account updated successfull');});</script>");
					redirect('admin/users');
				} else {
					unset($post['password']);
					$this->db->update('users', $post, ['id' => $id]);
					$this->session->set_flashdata('message', "<script>$(document).ready(function() { toastr.success('Account updated successfull');});</script>");
					redirect('admin/users');
				}
			}
		} else {
			$data['title'] = 'Users';
			$data['user'] = $this->db->get_where('users', ['id' => $id])->row();
			$this->template->load('/admin/base', '/admin/user_edit', $data);
		}
	}

	public function delete($id)
	{
		$is_superadmin = $this->session->userdata('role');
		$user = $this->db->get_where('users', ['id' => $id])->row();
		if ($is_superadmin != 3 && $user->role == 2) {
			$this->session->set_flashdata('message', "<script>$(document).ready(function() { toastr.info('You have not privilege');});</script>");
			redirect('admin/users');
		} else {
			$this->db->delete('users', ['id' => $id]);
			$this->session->set_flashdata('message', "<script>$(document).ready(function() { toastr.success('Account deleted successfull');});</script>");
			redirect('admin/users');
		}
	}
}
