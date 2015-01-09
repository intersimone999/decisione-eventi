<?php
	require_once "../config.php";
	require_once ROOT_DIR . '/core/UserControl.php';
	
	if (!isset($_POST['username']) || !isset($_POST['password'])) {
		redirect("error.php?id=2");
		die();
	}
	
	session_start();
	
	$user = new User($_POST['username']);
	$user->setPassword($_POST['password']);
		
	$control = new UserControl();
	if (!$control->addUser($user)) {
		redirect("../index.php?error=1");
		die();
	}
	
	$_SESSION['user'] = $control->getUser($_POST['username']);
	session_commit();
	
	redirect("dispatch.php");
?>