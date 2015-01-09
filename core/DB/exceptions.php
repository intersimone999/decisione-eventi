<?php
require_once "../config.php";
/**
 * Eccezione generica per le connessioni al database
 * @author simone
 *
 */
class DBException extends Exception {
	public function __construct($message) {
		parent::__construct("Errore DB: $message", 1, null);
	}
}

/**
 * La connessione è fallita o è stata chiusa
 * @author simone
 *
 */
class DBConnectionFailException extends DBException {
	public function __construct() {
		parent::__construct("Connessione fallita");
	}
}

/**
 * Il database non è stato trovato
 * @author simone
 *
 */
class DBNotFoundException extends DBException {
	public function __construct() {
		parent::__construct("Database non trovato");
	}
}

/**
 * Si prevedeva di recuperare un solo record, ma ne sono stati prelevati di più
 * @author simone
 * 
 */
class DBNotUniqueException extends DBException {
	public function __construct() {
		parent::__construct("È stato recuperato più di un record");
	}
}

?>