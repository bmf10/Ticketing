<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		is_admin();
		$this->load->model('M_dashboard', 'm_dash');
	}

	public function index()
	{
		$id = $this->session->userdata('id');

		$data['title'] = 'Dashboard';
		$data['user'] = $this->db->get_where('users', ['id' => $id])->row();
		$data['transaction'] = $this->m_dash->getTransaction();
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

	public function transaction($id = '')
	{
		if ($id == '') {
			response('error', 'not found', 404);
		}

		$transaction = $this->m_dash->getDetail($id);
		response('success', $transaction, '200');
	}

	public function executeTransaction($decision, $id)
	{
		if ($decision == 'Approve') {
			$this->db->update('transaction', ['status' => 'Approved'], ['id' => $id]);

			$tickets = $this->db->get_where('details_transaction', ['transaction_id' => $id])->result();
			foreach ($tickets as $index => $t) {
				$barcode = barcode_creator($id, $index);
				$this->db->update('details_transaction', ['barcode_number' => $barcode], ['id' => $t->id]);
			}
		} else if ($decision == 'Reject') {
			$this->db->update('transaction', ['status' => 'Rejected'], ['id' => $id]);
		}

		$this->session->set_flashdata('message', "<script>$(document).ready(function() { toastr.success('Update Successfully');});</script>");
		redirect('admin');
	}

	public function ticket_checker()
	{
		$barcode_number = $this->input->post('barcode_number');
		$tickets = $this->db->get_where('details_transaction', ['barcode_number' => $barcode_number]);

		if ($tickets->num_rows() > 0) {
			$ticket = $tickets->row();
			if ($ticket->is_used == 1) {
				response('error', ['error' => 'Barcode has been used'], 406);
			} else {
				$this->db->update('details_transaction', ['is_used' => 1], ['id' => $ticket->id]);
				response('success', ['success' => 'Barcode verified'], 200);
			}
		} else {
			response('error', ['error' => 'Barcode invalid'], 404);
		}
	}
}
