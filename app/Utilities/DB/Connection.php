<?php
namespace App\Utilities\DB;

use App\Utilities\Contracts\ConnectionContract;

class Connection implements ConnectionContract{

	public static $instance;

	protected $sql;

	protected $conn;

	protected $dbName;

	protected $dbPass;

	protected $host;

	protected $user;

	protected $result;

    protected $configPath = __DIR__.'/../../../config';

	

	public static function getInstance(){
		if (self::$instance instanceOf self) {
			return self::$instance;
		}else{
			self::$instance = new Connection;
			self::$instance->getConfig()->connect();
			return self::$instance;
		}

	}

	protected function getConfig(){
		// if (file_exists($this->configPath)) {
			// include($this->configPath);
		// $this->dbName = DBNAME;
		// $this->dbPass = DBPASS;
		// $this->host = DBHOST;
		// $this->user = DBUSER;

		// return $this;
		// }
		// else{
		// 	throw new \Exception("config file not found", 1);
			
		// }

		$this->dbName = config('database.DBNAME');
		$this->dbPass = config('database.DBPASS');
		$this->host = config('database.DBHOST');
		$this->user = config('database.DBUSER');

		return $this;
		
	}

	protected function connect(){

		$this->conn = mysqli_connect($this->host,$this->user,$this->dbPass,$this->dbName);
		if (!$this->conn) {
			throw new \Exception("Failed to connect: ".mysqli_connect_error());
			
		}
		return $this;
	}

	public function getMany($sql) :array
	{

		 
		$this->result = mysqli_query($this->conn,$sql);

		return mysqli_fetch_assoc($this->result);

	}

	public function getOne(){

	}

	public function getLast(){

	}

	public function getFirst(){

	}
	
	public function pushInsert($sql) :bool
	{
		return mysqli_query($this->conn,$sql);
	}
	public function deleteData($sql) :bool
	{
		return mysqli_query($this->conn, $sql);
	}
}