<?php

function is_logged_in($is_auth)
{
	$CI = &get_instance();
	$is_login = $CI->session->userdata('is_logged');
	if ($is_login) {
		redirect('profile');
	} else {
		if (!$is_auth) {
			$CI->session->set_userdata(['current_url' => current_url()]);
			redirect('auth');
		}
	}
}

function is_user()
{
	$is_user = $this->session->userdata('role');
}

function is_admin()
{
	$is_admin = $this->session->userdata('role');
}
