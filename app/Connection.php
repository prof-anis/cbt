<?php
namespace App;

class Connection{

	protected $sql;

	protected $conn;

	protected $dbName;

	protected $dbPass;

	protected $host;

	protected $user;

	protected $result;


	function __construct(){

		 

		$this->getConfig()
			->connect();

	}

	function __destruct(){
		if(mysqli_free_result($this->result)); //free result

    	mysqli_close($this->conn);

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
			throw new \Exception("Failed to connect: ".mysqli_connect_error());
			
		}
		return $this;
	}

	public function getMany($sql){

		 
		$this->result = mysqli_query($this->conn,$sql);

		return mysqli_fetch_assoc($this->result);

	}

	public function getOne(){

	}

	public function getLast(){

	}

	public function getFirst(){

	}
	
	public function pushInsert($sql){
		return mysqli_query($this->conn,$sql);
	}
	public function deleteData($sql){
		return mysqli_query($this->conn, $sql);
	}
}