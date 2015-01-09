<?php
class Car {
	private $id;
	private $owner;
	private $sits;
	
	public function getId() {
		return $this->id;
	}
	
	public function setId($id) {
		$this->id = $id;
	}
	
	public function getSits() {
		return $this->sits;
	}
	
	public function setSits($sits) {
		$this->sits = $sits;
	}
	
	public function getOwner() {
		return $this->owner;
	}
	
	public function setOwner($owner) {
		$this->owner = $owner;
	}
}
?>