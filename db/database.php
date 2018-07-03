<?php


class Database
{
    

	private $db;
	private $db_result;
	private $sth;
	
	public function __construct(){
		$this->connect();
	}
	
	private function connect(){
			$config = require_once("db_config.php");
			$dsn = "mysql:host=".$config['host'].";dbname=".$config['db_name'];
			$this->db = new PDO($dsn, $config['username'], $config['password']);
			$this->db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
			return $this;		
    }
		
	public function execute($sql){
		$this->sth = $this->db->prepare($sql);
		$this->sth->execute();
		//$db_result = $sth->fetchAll(PDO::FETCH_ASSOC);
		//if($db_result !== false){
			//return $db_result;
		//}		
	}
	public function lastInsertId(){
		return $this->db->lastInsertId();
	}
	
	public function getResult(){
		$db_result = $this->sth->fetchAll(PDO::FETCH_ASSOC);
		if($db_result !== false){
			return $db_result;
		}
	}
   
}

?>