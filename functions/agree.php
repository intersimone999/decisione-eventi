<?php
	require_once "../config.php";
	require_once ROOT_DIR . '/core/AgreementControl.php';
	require_once ROOT_DIR . '/core/Item.php';
	
	session_start();
	
	if (!isset($_GET['id']) || !isset($_SESSION['user']) || !isset($_GET['agree'])) {
		redirect("error.php?id=5");
		die();
	}
	
	$object = new Item();
	$object->setId($_GET['id']);
	
	$user = $_SESSION['user'];
	
	if ($_GET['agree'] == 0)
		$agree = false;
	else
		$agree = true; 
	
	$control = new AgreementControl();
	if (!$control->addAgreement($user, $object, $agree)) {
		redirect("error.php?id=3.1");
		die();
	}
	
	redirect("dispatch.php");
?>