<?php


function response($msg, $data, $status)
{
	header("Content-Type: application/json; charset=UTF-8");

	$response = [
		'status' => $status,
		'msg' => $msg,
		'data' => $data,
	];

	http_response_code($status);
	echo json_encode($response);
}
