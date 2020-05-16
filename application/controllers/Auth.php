<?php
defined('BASEPATH') or exit('No direct script access allowed');

use Twilio\Rest\Client;

class Auth extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		is_logged_in(true);
	}

	public function index()
	{
		$this->template->load('/user/base', '/user/auth');
	}

	public function register()
	{
		$this->form_validation->set_rules('name', 'Name', 'required|trim');
		$this->form_validation->set_rules('gender', 'Gender', 'required|trim');
		$this->form_validation->set_rules('address', 'address', 'required|trim');
		$this->form_validation->set_rules('phone', 'Phone', 'required|trim|is_unique[users.phone]');
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email|trim|is_unique[users.email]');
		$this->form_validation->set_rules('password', 'Password', 'required|trim|min_length[6]');

		if ($this->form_validation->run() === FALSE) {
			response('errors', $this->form_validation->error_array(), 422);
		} else {
			$password = $this->input->post('password');
			$data = $this->input->post();
			$data['password'] = password_hash($password, PASSWORD_DEFAULT);
			$data['code'] = substr(str_shuffle('0123456789'), 1, 6);
			$data['role'] = 1;

			try {
				$this->db->insert('users', $data);
				$this->db->insert_id();
				$this->sendCode($data['phone'], 'register', $data['code']);
				response('success', ['account_created' => true, 'phone' => $data['phone']], 200);
			} catch (Exception $e) {
				response('errors', $e->getMessage(), 422);
			}
		}
	}

	public function sendCode($phone, $codition, $code)
	{
		$account_sid = 'ACa419bc41f40a1008df27d0b1fa2a61b7';
		$auth_token = '5bd38d039daf72b622c90caab40b5d27';
		$twilio_number = "+12073674889";
		$phone_with_code = '+62' . substr($phone, 1);
		$client = new Client($account_sid, $auth_token);

		if ($codition === 'register') {
			$client->messages->create($phone_with_code, [
				'from' => $twilio_number,
				'body' => 'Terima kasih telah mendaftar di SIMPETUK, kode verifikasi akun anda yaitu ' . $code . '. Silahkan masukan pada form yang muncul di layar anda. :)'
			]);
		}
	}

	public function verification()
	{
		$phone = $this->input->post('phone');
		$code = $this->input->post('code');
		$user = $this->db->get_where('users', ['phone' => $phone])->row();

		if (!$user) {
			response('error', ['error' => 'Phone number not found'], 422);
		} else {
			if (!$user->code) {
				response('error', ['error' => 'Code number not found'], 422);
			} else {
				if ($user->code === $code) {
					try {
						$this->db->update('users', ['is_verified' => 1, 'code' => null], ['id' => $user->id]);
						response('success', ['is_verified' => true], 200);
					} catch (Exception $e) {
						response('errors', $e->getMessage(), 422);
					}
				} else {
					response('error', ['error' => 'Code number is wrong'], 422);
				}
			}
		}
	}

	public function login()
	{
		$email = $this->input->post('email');
		$password = $this->input->post('password');
		try {
			$result = $this->db->get_where('users', ['email' => $email]);

			if ($result->num_rows() === 0) {
				response('error', ['error' => 'Email not found'], 422);
			} else {
				if (password_verify($password, $result->row()->password) === true) {
					$data_session = [
						'id' => $result->row()->id,
						'role' => $result->row()->role,
						'is_logged' => true,
					];

					$this->session->set_userdata($data_session);

					response('success', ['is_logged' => true], 200);
				} else {
					response('error', ['error' => 'Wrong password'], 200);
				}
			}
		} catch (Exception $e) {
			response('errors', $e->getMessage(), 422);
		}
	}
}
