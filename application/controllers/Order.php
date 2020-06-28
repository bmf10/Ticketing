<?php
defined('BASEPATH') or exit('No direct script access allowed');


class Order extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		is_user();
	}

	public function index()
	{
		$data['ticket'] = $this->db->get('ticket')->result();
		$this->template->load('/user/base', '/user/order', $data);
	}

	public function process()
	{
		$id = $this->session->userdata('id');
		$user = $this->db->get_where('users', ['id' => $id])->row();
		if ($user->is_verified == 0) {
			response('error', ['error' => 'Please verification your account before'], 401);
			die;
		}

		$total = $this->input->post('total');
		$tickets = $this->input->post('data');

		$date = date("Y-m-d H:i:s");
		$expired = date("Y-m-d H:i:s", strtotime('+3 days'));
		$code = rand(100, 999);
		$total = $total - $code;
		$status = 'Waiting';
		$user_id = $id;

		$insert = [
			'date' => $date,
			'expired' => $expired,
			'user_id' => $user_id,
			'status' => $status,
			'total' => $total,
			'unique_code' => $code
		];

		try {
			$this->db->insert('transaction', $insert);
			$insert_id = $this->db->insert_id();

			foreach ($tickets as $t) {
				for ($i = 0; $i < $t['value']; $i++) {
					$ticket = [
						'date' => $date,
						'ticket' => $t['id'],
						'transaction_id' => $insert_id
					];
					$this->db->insert('details_transaction', $ticket);
				}
			}

			response('success', ['insert_id' => $insert_id], 200);
		} catch (Exception $e) {
			response('error', $e->getMessage(), '500');
		}
	}

	public function payment($id)
	{
		$transaction = $this->db->get_where('transaction', ['id' => $id])->row();
		$bank_account =  $this->db->get('bank', 1)->row();

		if ($transaction->status != 'Waiting') {
			redirect('profile');
		}

		$data['transaction'] = $transaction;
		$data['bank'] = $bank_account;
		$this->template->load('/user/base', '/user/payment', $data);
	}

	public function payments()
	{
		$upload = upload_img('proof_of_payment');
		if ($upload['fileuploaded']) {
			$id = $this->input->post('id');
			$data = [
				'bank_of_payment' => $this->input->post('bank_of_payment'),
				'name_of_payment' => $this->input->post('name_of_payment'),
				'proof_of_payment' => $upload['filename'],
				'status' => 'Payment'
			];

			$this->db->update('transaction', $data, ['id' => $id]);
			$this->session->set_flashdata('message', "<script>$(document).ready(function() { toastr.success('Your payment will be processed immediately');});</script>");
			redirect('profile');
		}
	}

	public function cancel($id)
	{
		$this->db->delete('transaction', ['id' => $id]);
		$this->db->delete('details_transaction', ['transaction_id' => $id]);
		$this->session->set_flashdata('message', "<script>$(document).ready(function() { toastr.success('Cancel Successfully');});</script>");
		redirect('profile');
	}
}
