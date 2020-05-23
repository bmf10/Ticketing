<?php

function is_login()
{
	$CI = &get_instance();
	$is_login = $CI->session->userdata('is_logged');
	if (!$is_login) {
		$CI->session->set_flashdata('message', "<script>$(document).ready(function() { toastr.error('Please login to continue');});</script>");
		redirect('/');
	}
}

function is_user()
{
	is_login();
	$CI = &get_instance();
	$is_user = $CI->session->userdata('role');
	if ($is_user != 1) {
		$CI->session->set_flashdata('message', "<script>$(document).ready(function() { toastr.warning('You dont have access');});</script>");
		redirect('/');
	}
}

function is_admin()
{
	is_login();
	$CI = &get_instance();
	$is_admin = $CI->session->userdata('role');
	if ($is_admin != 2 && $is_admin != 3) {
		$CI->session->set_flashdata('message', "<script>$(document).ready(function() { toastr.warning('You dont have access');});</script>");
		redirect('/');
	}
}

function is_staff()
{
	is_login();
	$CI = &get_instance();
	$is_staff = $CI->session->userdata('role');
	if ($is_staff != 4) {
		$CI->session->set_flashdata('message', "<script>$(document).ready(function() { toastr.warning('You dont have access');});</script>");
		redirect('/');
	}
}
