<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Profile extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		//view code here
	}

	public function profile_data()
	{
		$id = $this->session->userdata('id');
		try {
			$result = $this->db->get_where('users', ['id' => $id])->row();
			response('success', $result, 200);
		} catch (Exception $e) {
			response('errors', $e->getMessage(), 422);
		}
	}

	public function edit_profile()
	{
		$id = $this->session->userdata('id');
		$data = $this->input->post();

		if (!$data) {
			response('errors', ['error' => 'data not found'], 422);
		} else {
			try {
				$this->db->update('users', $data, ['id' => $id]);
				response('success', ['affected_rows' => $this->db->affected_rows()], 200);
			} catch (Exception $e) {
				response('errors', $e->getMessage(), 422);
			}
		}
	}

	public function change_password()
	{
		$id = $this->session->userdata('id');
		$data = $this->input->post();
		try {
			$result = $this->db->get_where('users', ['id' => $id])->row();
			if (password_verify($data['password'], $result->password) === true) {
				if ($data['new_password'] === $data['new_password_confirm']) {
					$update = [
						'password' => password_hash($data['new_password'], PASSWORD_DEFAULT)
					];
					$this->db->update('users', $update, ['id' => $id]);
					response('success', ['password' => 'password_updated'], 200);
				} else {
					response('errors', ['new_password' => 'doesnt match'], 422);
				}
			} else {
				response('errors', ['old_password' => 'wrong password'], 422);
			}
		} catch (Exception $e) {
			response('errors', $e->getMessage(), 422);
		}
	}

	public function logout()
	{
		$this->session->sess_destroy();
		response('success', ['is_logged' => false], 200);
	}
}
