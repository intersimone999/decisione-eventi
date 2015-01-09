<?php
require_once "../config.php";
require_once ROOT_DIR . "/core/DB/MySQLManager.php";

/**
 * 
 * Permette di istanziare il DBManager attualmente in uso. Modificando il metodo è possibile
 * modificare il DBManager
 * @author simone
 *
 */
class DBEngine {
	/**
	 * Istanzia il DBManager utilizzato
	 * @return DBManager
	 */
	public static function getDBManager() {
		$implementor = new MySQLManager();
		
		return $implementor;
	}
}
?>
