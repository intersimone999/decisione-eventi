<?php
class User {
	private $userid;
	private $name;
	private $password;
	
	public function __construct($name) {
		$this->setName($name);
	}
	
	public function setName($name) {
		$this->name = $name;
	}
	
	public function getName() {
		return $this->name;
	}
	
	public function setPassword($password) {
		$this->password = $password;
	}
	
	public function getPassword() {
		return $this->password;
	}
	
	public function setId($id) {
		$this->userid = $id;
	}
	
	public function getId() {
		return $this->userid;
	}
}
?>