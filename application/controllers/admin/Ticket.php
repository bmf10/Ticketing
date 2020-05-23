<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Ticket extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		is_admin();
	}

	public function index()
	{
		$data['title'] = 'Ticket';
		$data['ticket'] = $this->db->get('ticket')->result();
		$this->template->load('/admin/base', '/admin/ticket', $data);
	}

	public function process($id = '')
	{
		if ($id == '') {
			$post = $this->input->post();
			$this->db->insert('ticket', $post);
			response('success', 'Data created successfull', 200);
		} else {
			$post = $this->input->post();
			$this->db->update('ticket', $post, ['id' => $id]);
			response('success', 'Data updated successfull', 200);
		}
	}

	public function single($id)
	{
		$data = $this->db->get_where('ticket', ['id' => $id])->row();
		response('success', $data, 200);
	}

	public function delete($id)
	{
		$this->db->delete('ticket', ['id' => $id]);
		$this->session->set_flashdata('message', "<script>$(document).ready(function() { toastr.success('Ticket deleted successfull');});</script>");
		redirect('admin/ticket');
	}
}
