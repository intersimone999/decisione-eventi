<?php
require_once "../config.php";
require_once ROOT_DIR . "/config.php";
require_once ROOT_DIR . "/core/DB/exceptions.php";
require_once ROOT_DIR . "/core/DB/DBManager.php";

/**
 * Gestisce le connessioni al database. Una connessione verrà effettuata ogni volta che
 * la classe viene instanziata. Una volta chiusa la connessione non sarà più possibile
 * utilizzare i metodi.
 * @author simone
 * @version 1.0
 */
class MySQLManager implements DBManager {
	private $SERVER;
	private $USERNAME;
	private $PASSWORD;
	private $DBNAME;
	
	private $connection;
	
	/**
	 * Crea una nuova connessione al DBMS
	 * @throws DBException Se la connessione è stata chiusa
	 */
	public function __construct() {
		global $CFG;
		$this->SERVER = $CFG['DB_HOST'];
		$this->USERNAME = $CFG['DB_USERNAME'];
		$this->PASSWORD = $CFG['DB_PASSWORD'];
		$this->DBNAME = $CFG['DB_NAME'];
		
		$this->connection = $this->make_connection();
	}
	
	/**
	 * Chiude la connessione se non è stata chiusa quando la classe viene distrutta
	 */
	public function __destruct() {
		try {
			$this->close_connection();
		} catch (DBConnectionFailException $e) {}
	}
	
	/**
	 * Restituisce la connessione aperta
	 * @return La connessione
	 * @throws DBException Se la connessione è stata chiusa
	 */
	public function get_connection() {
		$this->check_connection();
		
		return $this->connection;
	}
	
	/**
	 * Esegue una query (SELECT) al DBMS
	 * @param string $pQuery
	 * @return Un array di risultati
	 * @throws DBException Se la connessione è stata chiusa
	 */
	public function get($pQuery) {
		$this->check_connection();
		
		$q = mysql_query($pQuery, $this->connection);
		
		$result = array();
		while (($element = mysql_fetch_assoc($q)) != null)
			$result[] = $element;
		
		return $result;
	}
	
	/**
	 * Esegue una query per la quale è previsto un solo record risultante
	 * @param string $pQuery La query da eseguire
	 * @return Il record ottenuto
	 * @throws DBNotUniqueException Se il record risultante non è uno (anche se è zero)
	 */
	public function get_unique($pQuery) {
		$temp = $this->get($pQuery);
		if (count($temp) != 1)
			throw new DBNotUniqueException();
		
		return $temp[0];
	}
	
	/**
	 * Aggiorna il database (INSERT, UPDATE o DELETE)
	 * @param string $pQuery
	 * @return Vero se l'operazione è riuscita
	 * @throws DBException Se la connessione è stata chiusa
	 */
	public function update($pQuery) {
		$this->check_connection();
		
		$q = mysql_query($pQuery, $this->connection);
		
		return $q;
	}
	
	/**
	 * Chiude la connessione se non è stata ancora chiusa
	 * @throws DBException Se la connessione è stata chiusa
	 */
	public function close_connection() {
		$this->check_connection();
	
		mysql_close($this->connection);
		$this->connection = null;
	}
	
	/**
	 * Converte una data dal formato MySql a quello PHP
	 * @param string $pMysqlDate
	 */
	public function convertDateToPhp($pMysqlDate) {
		return strtotime($pMysqlDate);
	}
	
	/**
	 * Converte una data dal formaty PHP a quello MySql
	 * @param int $pPhpDate
	 */
	public function convertDateFromPhp($pPhpDate) {
		return date("Y-m-d H:i:s", $pPhpDate);
	}
	
	/**
	 * Restituisce una stringa utilizzabile in una query
	 * @param string $pString
	 */
	public function escapeString($pString) {
		return mysql_real_escape_string($pString);
	}
	
	public function getLastError() {
		$this->check_connection();
		
		$error = mysql_error($this->connection);
		
		if ($error == "")
			return null;
		else
			return $error;
	}
	
	/**
	* Stabilisce una connessione.
	* @throws DBException Se si verifica un errore nella connessione o nella selezione del database
	*/
	private function make_connection() {
		$connection = mysql_connect($this->SERVER, $this->USERNAME, $this->PASSWORD);
		if (!@$connection)
		throw new DBConnectionFailException();
	
		$dbok = mysql_select_db($this->DBNAME, $connection);
	
		if (!$dbok)
		throw new DBNotFoundException();
	
		return $connection;
	}
	
	/**
	 * Controlla che la connessione sia ancora aperta
	 * @throws DBException Se la connessione è stata chiusa
	 */
	private function check_connection() {
		if (!$this->connection)
			throw new DBConnectionFailException();
	}
}

?>
