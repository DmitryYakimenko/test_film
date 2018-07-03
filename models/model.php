<?php


class Model
{
	protected $db;

	public function __construct(Database $db){
		$this->db = $db;
	}
/*	
	public function create($table_name, $attributes){}
	
	public function update($table_name, $attributes){}
	
	public function select($table_name, $attributes){}

	public function delete($table_name, $attributes){}
*/
   
}
?>