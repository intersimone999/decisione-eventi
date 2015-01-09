<?php
	require_once "../config.php";
	require_once ROOT_DIR . '/core/ListControl.php';
	require_once ROOT_DIR . '/core/UserControl.php';
	
	session_start();
	
	if (!isset($_POST['id']) || (!isset($_POST['object']) && !isset($_POST['quantity']))) {
		redirect("error.php?id=4");
		die();
	}
	
	$objectid = $_POST['id'];
	if ($CFG['EVT_TYPE'] == $EVT_SHARED) {
		$objectname = $_POST['object'];
		$object = new Item();
		$object->setId($objectid);
		$object->setName($objectname);
		
		$control = new ListControl();
		if (!$control->editObjectName($object)) {
			redirect("error.php?id=4.1");
			die();
		}
	} else {
		$objectqt = $_POST['quantity'];
		if ($objectqt < 0) {
			redirect("error.php?id=4");
			die();
		}
		
		$object = new Item();
		$object->setId($objectid);
		$object->setQuantity($objectqt);
		
		$control = new ListControl();
		if (!$control->editObjectQuantity($object)) {
			redirect("error.php?id=4.1");
			die();
		}
	}
	
	redirect("dispatch.php");
?>