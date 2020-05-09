<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
	}

	public function register()
	{

		$this->form_validation->set_rules('name', 'Name', 'required|trim');
		$this->form_validation->set_rules('gender', 'Gender', 'required|trim');
		$this->form_validation->set_rules('address', 'address', 'required|trim');
		$this->form_validation->set_rules('phone', 'Phone', 'required|trim');
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email|trim|is_unique[users.email]');
		$this->form_validation->set_rules('password', 'Password', 'required|trim|min_length[6]');

		if ($this->form_validation->run() === FALSE) {
			response('errors', $this->form_validation->error_array(), 422);
		} else {
			$password = $this->input->post('password');
			$data = [
				'name' => $this->input->post('name'),
				'gender' => $this->input->post('gender'),
				'address' => $this->input->post('address'),
				'phone' => $this->input->post('phone'),
				'email' => $this->input->post('email'),
				'password' => password_hash($password, PASSWORD_DEFAULT),
				'role' => 1
			];
			try {
				$this->db->insert('users', $data);
				$id = $this->db->insert_id();
				$this->verification($id, $data['email']);
			} catch (Exception $e) {
				response('errors', $e, 422);
			}
		}
	}

	public function verification($id, $email)
	{
		$encrypt = encrypt_url($id);

		$config = [
			'protocol' => 'smtp',
			'smtp_host' => 'smtp.hostinger.co.id',
			'smtp_port' => '587',
			'smtp_user' => 'example@siderajati.com',
			'smtp_pass' => '12345678',
			'mailtype' => 'html',
			'charset' => 'utf-8',
			'wordwrap' => TRUE,
			'priority' => 1
		];

		try {
			$this->email->initialize($config);
			$this->email->from('example@siderajati.com', 'noreply');
			$this->email->to($email);
			$this->email->subject("Verifikasi akun");
			$this->email->message("Klik link untuk verifikasi akun anda, <a href='" . site_url('auth/verify/?s=' . $encrypt) . "'>Klik Disini</a>");
			$sent = $this->email->send();
			echo $this->email->print_debugger();
			response('success', ['account_created' => true, 'email_sent' => $sent], 200);
		} catch (Exception $e) {
			response('errors', $e, 422);
		}
	}

	public function reset_password()
	{
		$email = $this->input->post('email');

		if ($this->db->get_where('users', ['email' => $email])->num_rows() > 0) {
			$encrypt = encrypt_url($email);
			$permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
			$new_password = encrypt_url(substr(str_shuffle($permitted_chars), 0, 16));

			$config = [
				'protocol' => 'smtp',
				'smtp_host' => 'smtp.hostinger.co.id',
				'smtp_port' => '587',
				'smtp_user' => 'example@siderajati.com',
				'smtp_pass' => '12345678',
				'mailtype' => 'html',
				'charset' => 'utf-8',
				'wordwrap' => TRUE,
				'priority' => 1
			];

			try {
				$this->email->initialize($config);
				$this->email->from($config['smtp_user'], 'noreply');
				$this->email->to($email);
				$this->email->subject("Reset Password");
				$this->email->message("Klik link untuk reset password anda, <a href='" . site_url('auth/reset/?s=' . $encrypt . '&p=' . $new_password) . "'>Klik Disini</a>");
				$this->email->send();
				response('success', ['email_sent' => true], 200);
			} catch (Exception $e) {
				response('errors', $e, 422);
			}
		} else {
			response('errors', ['error' => 'email is not found'], 404);
		}
	}

	public function reset()
	{
		if (isset($_GET['s']) && isset($_GET['p'])) {
			$email = decrypt_url($_GET['s']);
			$new_password = decrypt_url($_GET['p']);

			$result = $this->db->get_where('users', ['email' => $email]);

			if ($result->num_rows() > 0) {
				try {
					$this->db->update('users', ['password' => password_hash($new_password, PASSWORD_DEFAULT)], ['email' => $email]);
					response('success', ['email' => $email, 'new_password' => $new_password], 200);
				} catch (Exception $e) {
					response('errors', $e, 422);
				}
			} else {
				response('errors', ['error' => 'reset code is not valid'], 422);
			}
		} else {
			response('errors', ['error' => 'reset code is not found'], 404);
		}
	}

	public function verify()
	{
		if (isset($_GET['s'])) {
			$id = decrypt_url($_GET['s']);
			try {
				$this->db->update('users', ['is_verified' => 1], ['id' => $id]);
				response('success', ['id' => $id, 'is_verified' => true], 200);
			} catch (Exception $e) {
				response('errors', ['error' => 'reset code is not valid'], 422);
			}
		} else {
			response('errors', ['error' => 'reset code is not found'], 404);
		}
	}

	public function login()
	{
		$email = $this->input->post('email');
		$password = $this->input->post('password');
		try {
			$result = $this->db->get_where('users', ['email' => $email]);

			if ($result->num_rows() === 0) {
				response('error', ['error' => 'Email not found'], 404);
			} else {
				if (password_verify($password, $result->row()->password) === true) {
					$data_session = [
						'id' => $result->row()->id,
						'is_logged' => true,
					];

					$this->session->set_userdata($data_session);

					response('success', ['is_logged' => true], 200);
				} else {
					response('error', ['error' => 'Wrong password'], 200);
				}
			}
		} catch (Exception $e) {
			response('errors', $e, 422);
		}
	}
}
