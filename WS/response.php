<?php

function response($tag, $success, $error, $customData=""){
	// response Array
	$response = array("tag" => "default", "success" => 0, "error" => 0, "data" => "");
	if(isset($tag)) {
		$response['tag'] = $tag;
	}
	if(isset($success)) {
		$response['success'] = $success;
	}
	if(isset($error)) {
		$response['error'] = $error;
	}
	if(isset($customData)) {
		$response['data'] = $customData;
	}
	echo json_encode($response);
}