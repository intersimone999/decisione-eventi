<?php
require_once "../config.php";
require_once ROOT_DIR . "/core/DB/DBEngine.php";
require_once ROOT_DIR . "/core/User.php";
require_once ROOT_DIR . "/core/ChatControl.php";

class UserControl {
	public function addUser($user) {
		$engine = DBEngine::getDBManager();

		$username = $engine->escapeString($user->getName());
		$password = md5($user->getPassword());

		try {
			$result = $engine->get_unique("SELECT * FROM users WHERE name = '$username'");
			
			if ($result['password'] == $password)
				return true;
			else
				return false;
		} catch (DBNotUniqueException $e) {
			$engine->update("INSERT INTO users (name, password) VALUES ('$username', '$password')");
			$chatControl = new ChatControl();
			$chatControl->sendMessages($this->getSystemUser(), "Benvenuto, $username!");
			return true;
		}
	}

	public function getUser($username) {
		$engine = DBEngine::getDBManager();

		$username = $engine->escapeString($username);

		$data = $engine->get_unique("SELECT name, id FROM users WHERE name = '$username'");

		$result = new User($data['name']);
		$result->setId($data['id']);
		
		return $result;
	}
	
	public function getAllUsers() {
		$engine = DBEngine::getDBManager();
		
		$data = $engine->get("SELECT id, name FROM users");
		
		foreach ($data as $row) {
			$user = new User($row['name']);
			$user->setId($row['id']);
			$users[] = $user;
		}
		
		return $users;
	}
	
	public function getSystemUser() {
		return $this->getUser("System");
	}
}
?>