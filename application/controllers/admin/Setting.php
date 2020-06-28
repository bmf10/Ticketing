<?php

defined('BASEPATH') or exit('No direct script access allowed');

use Twilio\Rest\Client;

class Setting extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		is_admin();
	}

	public function index()
	{
		$data['title'] = 'Setting';
		$data['twilio_auth_token'] = $this->db->get_where('setting', ['alias' => 'twilio_auth_token'])->row();
		$data['twilio_account_sid'] = $this->db->get_where('setting', ['alias' => 'twilio_account_sid'])->row();
		$data['twilio_number'] = $this->db->get_where('setting', ['alias' => 'twilio_number'])->row();
		$data['bank'] = $this->db->get('bank', 1)->row();
		$this->template->load('/admin/base', '/admin/setting', $data);
	}

	public function sms()
	{
		$account_sid = $this->db->get_where('setting', ['alias' => 'twilio_account_sid'])->row()->value;
		$auth_token = $this->db->get_where('setting', ['alias' => 'twilio_auth_token'])->row()->value;
		$twilio_number = $this->db->get_where('setting', ['alias' => 'twilio_number'])->row()->value;
		$phone_with_code = '+62' . $this->input->post('number_phone');
		$client = new Client($account_sid, $auth_token);

		try {
			$client->messages->create($phone_with_code, [
				'from' => $twilio_number,
				'body' => 'Tes SMS'
			]);
			$this->session->set_flashdata('message', "<script>$(document).ready(function() { toastr.success('Success');});</script>");
			redirect('admin/setting');
		} catch (Exception $e) {
			$this->session->set_flashdata('message', "<script>$(document).ready(function() { toastr.error('" . $e->getMessage() . "');});</script>");
			redirect('admin/setting');
		}
	}

	public function twilio()
	{
		$token = $this->input->post('twilio_auth_token');
		$sid = $this->input->post('twilio_account_sid');
		$phone = $this->input->post('twilio_number');

		$this->db->update('setting', ['value' => $token], ['alias' => 'twilio_auth_token']);
		$this->db->update('setting', ['value' => $sid], ['alias' => 'twilio_account_sid']);
		$this->db->update('setting', ['value' => $phone], ['alias' => 'twilio_number']);

		$this->session->set_flashdata('message', "<script>$(document).ready(function() { toastr.success('Update Success');});</script>");
		redirect('admin/setting');
	}

	public function bank()
	{
		$data = $this->input->post();
		$id = $this->input->post('id');

		$this->db->update('bank', $data, ['id' => $id]);
		$this->session->set_flashdata('message', "<script>$(document).ready(function() { toastr.success('Update Success');});</script>");
		redirect('admin/setting');
	}
}
