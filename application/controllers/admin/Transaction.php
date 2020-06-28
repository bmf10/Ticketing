<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Transaction extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		is_admin();
		$this->load->model('M_transaction', 'm_trans');
	}

	public function index()
	{
		$data['title'] = 'Transaction';
		$data['transaction'] = $this->m_trans->getAll();
		$this->template->load('/admin/base', '/admin/transaction', $data);
	}

	public function detail($id)
	{
		$transaction = $this->m_trans->getDetail($id);
		response('success', $transaction, 200);
	}
}
