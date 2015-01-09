<?php
require_once "../config.php";
require_once ROOT_DIR . "/core/DB/DBEngine.php";
require_once ROOT_DIR . "/core/Item.php";

class ListControl {
	function __construct() {
		
	}
	
	public function getList() {
		$engine = DBEngine::getDBManager();
		
		$listOk = $engine->get(
				"SELECT o.id AS id, u.name AS user, o.name AS object, o.quantity AS quantity " .
				"FROM users AS u, objects AS o " .
				"WHERE u.id = o.owner AND " .
					"(SELECT COUNT(*) FROM agree AS a WHERE a.object = o.id AND a.agree = 1) > ((SELECT COUNT(*) FROM users)/2) " .
				"ORDER BY id");
		
		$listMiddle = $engine->get(
				"SELECT o.id AS id, u.name AS user, o.name AS object, o.quantity AS quantity " .
				"FROM users AS u, objects AS o " .
				"WHERE u.id = o.owner AND " .
				"(SELECT COUNT(*) FROM agree AS a WHERE a.object = o.id AND a.agree = 1) <= ((SELECT COUNT(*) FROM users)/2) AND" .
				"(SELECT COUNT(*) FROM agree AS a WHERE a.object = o.id AND a.agree = 0) <= (SELECT COUNT(*) FROM agree AS a WHERE a.object = o.id AND a.agree = 1)" . 
				"ORDER BY id");
		
		$listBad = $engine->get(
				"SELECT o.id AS id, u.name AS user, o.name AS object, o.quantity AS quantity " .
				"FROM users AS u, objects AS o " .
				"WHERE u.id = o.owner AND " .
				"(SELECT COUNT(*) FROM agree AS a WHERE a.object = o.id AND a.agree = 0) > (SELECT COUNT(*) FROM agree AS a WHERE a.object = o.id AND a.agree = 1)" .
				"ORDER BY id");
		
		$list = array_merge($listOk, $listMiddle, $listBad);
		
		return $list;
	}
	
	public function addObject($object) {
		$engine = DBEngine::getDBManager();
		
		$objname = $engine->escapeString($object->getName());
		$ownerid = $object->getOwner()->getId();
		$objqt = $object->getQuantity();
		
		$result = $engine->update("INSERT INTO objects (name, owner, quantity) VALUES ('$objname', $ownerid, '$objqt')");
		
		return $result;
	}
	
	public function editObjectName($object) {
		$engine = DBEngine::getDBManager();
		
		$objid = $object->getId();
		$objname = $engine->escapeString($object->getName());
		
		$result = $engine->update("UPDATE objects SET name = '$objname' WHERE id = $objid");
		
		return $result;
	}
	
	public function editObjectQuantity($object) {
		$engine = DBEngine::getDBManager();
	
		$objid = $object->getId();
		$objqt = $object->getQuantity();
	
		$result = $engine->update("UPDATE objects SET quantity = '$objqt' WHERE id = $objid");
	
		return $result;
	}
}
?>