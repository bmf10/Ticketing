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

function datetime($date)
{
	$temp = strtotime($date);
	$result = date('d-M-Y H:i', $temp);

	return $result;
}

function rupiah($money)
{
	$result = number_format($money);

	return 'Rp ' . $result;
}

function upload_img($name)
{
	if (!file_exists($_FILES[$name]['tmp_name'])) {
		header('HTTP/1.0 400 Bad error');
		echo "Please insert the file";
		die;
	}

	$files = $_FILES[$name]['name'];
	$ext = pathinfo($files, PATHINFO_EXTENSION);
	if ($ext != "jpg" && $ext != "png" && $ext != "jpeg" && $ext != "gif") {
		header('HTTP/1.0 400 Bad error');
		echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
		die;
	}

	$path = './upload/';
	if (isset($_FILES[$name]['name'])) {
		$file_uploaded = false;
		$filename = '';
		$tmpFilePath = $_FILES[$name]['tmp_name'];
		if (!empty($tmpFilePath) && $tmpFilePath != '') {
			_maybe_create_upload_path($path);
			$filename =  time() . '~' . $_FILES[$name]['name'];
			$newFilePath = $path . $filename;
			if (move_uploaded_file($tmpFilePath, $newFilePath)) {
				$file_uploaded = true;
			}
		}
	}

	$return = [
		'fileuploaded' => $file_uploaded,
		'filename' => $filename
	];

	return $return;
}

function _maybe_create_upload_path($path)
{
	if (!file_exists($path)) {
		mkdir($path, 0755);
		fopen(rtrim($path, '/') . '/' . 'index.html', 'w');
	}
}

// unique_code = index
function barcode_creator($id, $unique_code)
{
	$barcode = $id . time() . $unique_code;
	return $barcode;
}
