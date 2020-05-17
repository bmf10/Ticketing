<?php
defined('BASEPATH') or exit('No direct script access allowed');

use Twilio\Rest\Client;

class Profile extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		is_logged_in(false, true);
	}

	public function index()
	{
		$id = $this->session->userdata('id');
		$data['profile'] = $this->db->get_where('users', ['id' => $id], 1)->row();
		$this->template->load('/user/base', '/user/profile', $data);
	}

	public function edit_profile()
	{
		$id = $this->session->userdata('id');
		$profile = $this->db->get_where('users', ['id' => $id])->row();
		$data = $this->input->post();

		if (!$data) {
			response('errors', ['error' => 'data not found'], 422);
		} else {
			if ($profile->phone !== $data['phone']) {
				$this->form_validation->set_rules('phone', 'Phone', 'is_unique[users.phone]');

				if ($this->form_validation->run() === FALSE) {
					response('errors', $this->form_validation->error_array(), 422);
				} else {
					$data['code'] = substr(str_shuffle('0123456789'), 1, 6);
					$data['is_verified'] = 0;
					$this->db->update('users', $data, ['id' => $id]);
					try {
						$this->sendCode($data['phone'], 'edit', $data['code']);
						response('success', ['affected_rows' => $this->db->affected_rows(), 'phone' => $data['phone']], 200);
					} catch (Exception $e) {
						response('errors', $e->getMessage(), 422);
					}
				}
			} else {
				$this->db->update('users', $data, ['id' => $id]);
				response('success', ['affected_rows' => $this->db->affected_rows()], 200);
			}
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

	public function resendCode()
	{
		$id = $this->session->userdata('id');
		$profile = $this->db->get_where('users', ['id' => $id])->row();
		try {
			$this->sendCode($profile->phone, 'resend', $profile->code);
			response('success', ['delivered' => true], 200);
		} catch (Exception $e) {
			response('errors', $e->getMessage(), 422);
		}
	}

	public function sendCode($phone, $condition, $code)
	{
		$account_sid = 'ACa419bc41f40a1008df27d0b1fa2a61b7';
		$auth_token = '5bd38d039daf72b622c90caab40b5d27';
		$twilio_number = "+12073674889";
		$phone_with_code = '+62' . substr($phone, 1);
		$client = new Client($account_sid, $auth_token);

		switch ($condition) {
			case 'register':
				$client->messages->create($phone_with_code, [
					'from' => $twilio_number,
					'body' => 'Terima kasih telah mendaftar di SIMPETUK, kode verifikasi akun anda yaitu ' . $code . '. Silahkan masukan pada form yang muncul di layar anda. :)'
				]);
				break;
			case 'edit':
				$client->messages->create($phone_with_code, [
					'from' => $twilio_number,
					'body' => 'Nomor anda telah diubah, kode verifikasi anda yaitu ' . $code . '. Silahkan masukan pada form yang muncul di layar anda. SIMPETUK'
				]);
				break;
			case 'resend':
				$client->messages->create($phone_with_code, [
					'from' => $twilio_number,
					'body' => 'Hai, lupa kode verifikasi mu ya? ini kodenya ku kirim lagi ' . $code . '. Silahkan masukan pada form yang muncul di layar anda. Terima Kasih. SIMPETUK'
				]);
				break;
			default:
				$client->messages->create($phone_with_code, [
					'from' => $twilio_number,
					'body' => 'Terima kasih telah mendaftar di SIMPETUK, kode verifikasi akun anda yaitu ' . $code . '. Silahkan masukan pada form yang muncul di layar anda. :)'
				]);
				break;
		}
	}

	public function change_password()
	{
		$id = $this->session->userdata('id');
		$data = $this->input->post();

		try {
			$result = $this->db->get_where('users', ['id' => $id])->row();
			if (password_verify($data['old_password'], $result->password) === true) {
				$update = [
					'password' => password_hash($data['new_password'], PASSWORD_DEFAULT)
				];
				$this->db->update('users', $update, ['id' => $id]);
				response('success', ['password' => 'password_updated'], 200);
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
		redirect('auth');
	}
}
