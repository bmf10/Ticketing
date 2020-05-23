<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Home extends CI_Controller
{

	public function index()
	{
		$data['price'] = $this->db->get('ticket')->result();
		$this->template->load('/user/base', '/user/home', $data);
	}
}
