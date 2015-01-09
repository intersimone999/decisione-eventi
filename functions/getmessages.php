<?php
	require_once "../config.php";
	require_once ROOT_DIR . "/core/ChatControl.php";
	
//{"messages" : [{"author": "Simone", "message": "Ciao a tutti!"}, {"author": "AAA", "message": "Ciao a tutti!"}]}
	
	session_start();
	
	if (!isset($_GET['since']) || !isset($_SESSION['user'])) {
		redirect("error.php?id=3");
		die();
	}
	
	$since = intval($_GET['since']);
	
	$control = new ChatControl();
	$time = round(microtime(true) * 1000);
	$messages = $control->getMessages($since);
	
	$json_array = json_encode($messages);
	
	$result = "{\"messages\" : $json_array, \"time\" : $time}";
	
	echo $result;
?>
