<?php


class Film extends Model
{
    private $table_name = 'films';
	private $cross_table = 'film_star';
	private $attributes = '(films.title, films.release, films.format)';
    private $title;
	private $release;
	private $format;
	private $stars;
    private $sql;

	public function create($title,$release,$format, $stars = array()){
		$values = '(\''.$title.'\', \''.$release.'\', \''.$format.'\')';
		$sql = "INSERT INTO ".$this->table_name." ".$this->attributes." VALUES ".$values;
		$this->db->execute($sql);
		$film_id = $this->db->lastInsertId();
		if(!empty($stars)){
			foreach($stars as $star){
				$star_object = new Star($this->db);
                if($star_object->unique_star($star['name'],$star['surname']) === null){
                    $star_object->create($star['name'],$star['surname']);
				    $star_id = $star_object->db->lastInsertId();
                }else{
				    $star_id = $star_object->unique_star($star['name'],$star['surname']);
                }
                $this->link_table($film_id, $star_id);
			}
		}
		return $this->db;
	}
	
	public function link_table($film_id, $star_id){
		$values = '(\''.$film_id.'\', \''.$star_id.'\')';
		$sql = "INSERT INTO film_star (film_id, star_id) VALUES ".$values;
		$this->db->execute($sql);
	}
	
	public function select(){

			$this->sql = "SELECT DISTINCT films.*, GROUP_CONCAT(CONCAT(stars.name,' ',stars.surname)) as stars FROM " . $this->table_name ." ";
           return $this;
	}
    public function join(){
        $this->sql .= "LEFT JOIN film_star ON films.film_id = film_star.film_id
                       LEFT JOIN stars ON stars.star_id = film_star.star_id ";
        return $this;
    }
    
    public function where($data = array()){
        $key = array_keys($data)[0];
  
        $this->sql .= "WHERE (". $this->table_name . "." . $key ." = \""  . $data[$key]. "\") ";

        return $this;
    }
    
    public function like($data = array()){
        $count = 0;
        //print_r($data);die;
        foreach($data as $key => $value){
            if($value === ''){
                unset($data[$key]);
            }
        }
        
        foreach($data as $key => $value){
            if($count === 0){
                $this->sql .= "WHERE (". $key ." LIKE \"%".$value."%\") ";
            }else{
                $this->sql .= "AND (" . $key ." LIKE \"%".$value."%\") ";
            }
            $count++; 
        }
        return $this;
    }
    
    public function andLike($data = array()){
        foreach($data as $key => $value){
            $this->sql .= "AND (" . $key ." LIKE \"%".$value."%\") ";
        }
        return $this;
    }
    
    
    public function orderBy($order_by = "ASC", $column = "title"){
        $this->sql .= "ORDER BY " . $this->table_name . "." . $column . " " . $order_by;
       
        return $this;
        
    }
    public function groupBy($column){
        $this->sql .= "GROUP BY " . $this->table_name . ".".$column." ";
       
        return $this;
        
    }
    
    public function run(){
    //var_dump($this->sql);die;
        $this->db->execute($this->sql);
		$films =  $this->db->getResult();
        //var_dump($films);die;

		return $films;
    }
    public function starName(){
        $this->sql = "SELECT DISTINCT films.film_id, films.title, films.release, films.format, GROUP_CONCAT(CONCAT(stars.name,' ',stars.surname)) as stars FROM " . $this->table_name ." ";
        $this->sql .= "INNER JOIN film_star ON films.film_id = film_star.film_id
					   INNER JOIN stars ON stars.star_id = film_star.star_id ";
        $this->sql .= "WHERE stars.name LIKE \"%link%\" ";
        //$this->sql .= "GROUP BY stars.name";
        var_dump($this->sql);die;
    }
    
	public function view($id){
		$sql = "SELECT * FROM ".$this->table_name." WHERE (film_id = ".$id.")";
		$this->db->execute($sql);
		//print_r($this->db->getResult()[0]);die;
		$film = $this->db->getResult()[0];
		$film = $this->stars($film);
		return $film;
	}
    
    public function delete($id){
		$sql = "DELETE FROM ".$this->table_name." WHERE (film_id = ".$id.")";
		$this->db->execute($sql);
		//print_r($this->db->getResult()[0]);die;
	}
	//поиск актеров по фильму
	private function stars(array $film){
		$sql = "SELECT stars.name, stars.surname FROM films
					INNER JOIN film_star ON films.film_id = film_star.film_id
					INNER JOIN stars ON stars.star_id = film_star.star_id
					WHERE films.film_id =".$film['film_id'];
		$this->db->execute($sql);
		$stars = $this->db->getResult();
		foreach($stars as $star){
			$film['stars'] .= $star['name'].' '.$star['surname'].', ';
		}
		return $film;
	}
	public function selectByTitle($title){
		$sql = "SELECT * FROM films WHERE films.title = ".$title;
	}
	public function selectByStar($star){

	}
   
}

?>