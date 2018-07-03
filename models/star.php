<?php


class Star extends Model
{
    private $table_name = 'stars';
	private $attributes = '(stars.name, stars.surname)';
    private $title;
	private $release;
	private $format;
	private $films;

	public function create($name, $surname){
		$values = '(\''.$name.'\', \''.$surname.'\')';
		$sql = "INSERT INTO ".$this->table_name." ".$this->attributes." VALUES ".$values;
		$this->db->execute($sql);
		return $this->db;
	}
    public function unique_star($name,$surname){
        $sql = "SELECT star_id FROM stars WHERE (stars.name = \"".$name."\") AND (stars.surname = \"".$surname."\") ";
        $this->db->execute($sql);
        $result = $this->db->getResult();
        return !empty($result[0]['star_id'])?$result[0]['star_id']:null;
    }
   
}

?>