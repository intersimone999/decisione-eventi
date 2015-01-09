<?php
require_once "../config.php";
/**
 * 
 * Tutti i DBManager concreti devono contenere i metodi di questa interfaccia
 * @author simone
 *
 */
interface DBManager {
	/**
	 * 
	 * Restituisce l'handler alla connessione (dipende dal DBMS)
	 */
	public function get_connection();
	
	/**
	 * 
	 * Restituisce un array contenente i record risultanti dall'esecuzione della query 
	 * specificata al DBMS. Ogni record dev'essere un array associativo.
	 * Il metodo <i>get</i> dovrebbe essere usato solo per query di tipo SELECT.
	 * @param string $pQuery
	 * @return array
	 */
	public function get($pQuery);
	
	/**
	 * 
	 * Restituisce un singolo record risultante dall'esecuzione della query specificata.
	 * Il metodo <i>get_unique</i> dovrebbe essere usato solo per query di tipo SELECT.
	 * @param string $pQuery
	 * @return array
	 * @throws DBNotUniqueException Se il risultato della query non è un singolo record
	 */
	public function get_unique($pQuery);
	
	/**
	 * 
	 * Aggiorna lo stato del database, quindi modifica, aggiunge o elimina record da una
	 * o più tabelle.
	 * Il metodo <i>update</i> dovrebbe essere usato solo per query di tipo UPDATE, INSERT
	 * o DELETE.
	 * @param string $pQuery
	 * @return boolean Il successo o meno dell'operazione
	 */
	public function update($pQuery);
	
	/**
	 * 
	 * Chiude la connessione al DBMS.
	 */
	public function close_connection();
	
	/**
	 * 
	 * Converte una data dal formato del DBMS a quello standard PHP
	 * @param string $pDate
	 * @return int
	 */
	public function convertDateToPhp($pDate);
	
	/**
	 * 
	 * Converte una data dal formato standard PHP a quello usato dal DBMS
	 * @param int $pDate
	 * @return string
	 */
	public function convertDateFromPhp($pDate);
	
	/**
	 * 
	 * Restituisce la stringa con gli eventuali caratteri di escape
	 * @param string $pString
	 * @return string
	 */
	public function escapeString($pString);
	
	
	/**
	 * 
	 * Restituisce informazioni sull'ultimo errore verificatosi
	 * @return string L'ultimo errore verificatosi (o null)
	 */
	public function getLastError();
}
?>