<?php
namespace App;

class Connection{

	protected $sql;

	protected $conn;

	protected $dbName;

	protected $dbPass;

	protected $host;

	protected $user;


	function __construct(){

		 

		$this->getConfig()
			->connect();

	}

	protected function getConfig(){
		require __DIR__."../../config.php";
		$this->dbName = DBNAME;
		$this->dbPass = DBPASS;
		$this->host = DBHOST;
		$this->user = DBUSER;

		return $this;
	}

	protected function connect(){

		$this->conn = mysqli_connect($this->host,$this->user,$this->dbPass,$this->dbName);
		if (!$this->conn) {
			throw new \Exception(mysqli_connect_error());
			
		}
		return $this;
	}

	public function getMany($sql){

		 
		$result = mysqli_query($this->conn,$sql);

		return mysqli_fetch_assoc($result);

	}

	public function getOne(){

	}

	public function getLast(){

	}

	public function getFirst(){

	}
}