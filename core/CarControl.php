<?php
require_once "../config.php";
require_once ROOT_DIR . "/core/DB/DBEngine.php";
require_once ROOT_DIR . "/core/Car.php";

class CarControl {
	public function getAllCars() {
		$engine = DBEngine::getDBManager();
		
		$cars = $engine->get("SELECT c.id AS id, u.name AS user, c.sits AS sits FROM cars AS c, users AS u WHERE u.id = c.owner");
		
		return $cars;
	}
	
	public function addCar($car) {
		$engine = DBEngine::getDBManager();
		
		$owner = $car->getOwner()->getId();
		$sits = intval($car->getSits());
		
		$result = $engine->update("INSERT INTO cars (owner, sits) VALUES ($owner, $sits)");
		
		return $result;
	}
}
?>