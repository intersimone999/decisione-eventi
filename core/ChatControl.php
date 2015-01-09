<?php
require_once "../config.php";
require_once ROOT_DIR . "/core/DB/DBEngine.php";
require_once ROOT_DIR . "/core/UserControl.php";

class ChatControl {
	public function getMessages($since) {
		$engine = DBEngine::getDBManager();

		$result = $engine->get("SELECT u.name AS author, c.message AS message, c.time AS time FROM chat AS c, users AS u WHERE u.id = c.from AND time >= '$since' ORDER BY time ASC");
		
		return $result;
	}
	
	public function sendMessages($author, $message) {
		$engine = DBEngine::getDBManager();
	
		$message = $engine->escapeString($message);
		$authorid = $author->getId();
		$time = round(microtime(true) * 1000);
	
		$result = $engine->update("INSERT INTO chat (`from`, message, `time`) VALUES ($authorid, \"$message\", $time)");
	
		return $result;
	}
}
?>