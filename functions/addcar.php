<?php
	require_once "../config.php";
	require_once ROOT_DIR . '/core/CarControl.php';
	require_once ROOT_DIR . '/core/UserControl.php';
	
	session_start();
	
	if (!isset($_POST['sits']) || !isset($_SESSION['user'])) {
		redirect("error.php?id=5");
		die();
	}
	
	if (intval($_POST['sits']) <= 0 || intval($_POST['sits']) > 12) {
		
		redirect("error.php?id=Davvero hai un pullman?");
		die();
	}
	
	$carsits = intval($_POST['sits']);
	$car = new Car();
	$car->setSits($carsits);
	$car->setOwner($_SESSION['user']);
	
	$control = new CarControl();
	if (!$control->addCar($car)) {
		redirect("error.php?id=5.2");
		die();
	}
	
	redirect("cars.php");
?>