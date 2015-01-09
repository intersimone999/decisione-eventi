<?php
require_once "../config.php";
require_once ROOT_DIR . "/core/DB/DBEngine.php";
require_once ROOT_DIR . "/core/User.php";

class AgreementControl {
	public function addAgreement($user, $object, $agree) {
		$engine = DBEngine::getDBManager();

		$userid = $user->getId();
		$objectid = $object->getId();
		if ($agree)
			$agrm = 1;
		else
			$agrm = 0;
		
		$likes = $engine->get("SELECT * FROM agree WHERE user = $userid AND object = $objectid");
		
		$result = true;
		if (count($likes) == 0)
			$result = $engine->update("INSERT INTO agree (user, object, agree) VALUES ($userid, $objectid, $agrm)");
		else
			$result = $engine->update("UPDATE agree SET agree = $agrm WHERE object = $objectid AND user = $userid");
		
		return $result;
	}
	
	public function getPositiveAgreements($object) {
		$engine = DBEngine::getDBManager();
		
		$objectid = $object->getId();
		$resultPositive = $engine->get("SELECT u.name FROM agree AS a, users AS u WHERE a.user = u.id AND a.agree = 1 AND a.object = $objectid");
		
		$result = array();
		foreach ($resultPositive as $positive) {
			$result[] = $positive['name'];
		}
		
		return $result;
	}
	
	public function getNegativeAgreements($object) {
		$engine = DBEngine::getDBManager();
	
		$objectid = $object->getId();
		$resultNegative = $engine->get("SELECT u.name FROM agree AS a, users AS u WHERE a.user = u.id AND a.agree = 0 AND a.object = $objectid");
	
		$result = array();
		foreach ($resultNegative as $negative) {
			$result[] = $negative['name'];
		}
		
		return $result;
	}
}
?>