<?php
	require_once "../config.php";
	require_once ROOT_DIR . '/core/ListControl.php';
	require_once ROOT_DIR . '/core/UserControl.php';
	
	session_start();
	
	if (!isset($_POST['object']) || !isset($_SESSION['user'])) {
		redirect("error.php?id=3");
		die();
	}
	
	$objectname = $_POST['object'];
	$object = new Item();
	$object->setName($objectname);
	$object->setOwner($_SESSION['user']);
	if (isset($_POST['quantity']))
		$object->setQuantity($_POST['quantity']);
	
	$control = new ListControl();
	if (!$control->addObject($object)) {
		redirect("error.php?id=3.1");
		die();
	}
	
	redirect("dispatch.php");
?>