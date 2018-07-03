<?php
include("models/film.php");

class FilmController extends Controller{
	//private $order_by = "ASC";
	
	
    public function addAction($data = null){

		if(!empty($data['POST'])){
			$data= $data['POST'];
			$film = new Film(Init::getDb());
			
			$film->create($data['title'],$data['release'],$data['format'],$data['stars']);
            Init::redirect("/film/index");
		}
		//var_dump(htmlspecialchars($view->display()));die;
    }
    
    public function importAction($data = null){
        
      

		if(!empty($data['FILES'])){
			$data= $data['FILES']['file'];
            $fp =  file($data['tmp_name'],FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES );
            foreach($fp as $element){
                    $file[] = explode(':', $element);
            }
            $flag = 0;
            $count = 0;
            foreach($file as $element){ 
                switch($flag){
                    case 0:{
                        $films[$count]['title'] = ltrim($element[1]);
                        $flag++;
                        break;
                    }
                    case 1:{
                        $films[$count]['release'] = ltrim($element[1]);
                        $flag++;
                        break;
                    }
                    case 2:{
                        $films[$count]['format'] = ltrim($element[1]);
                        $flag++;
                        break;
                    }
                    case 3:{
                        $stars = explode(',', $element[1]);
                        $star_count = 0;
                        foreach($stars as $star){
                            $temp_star = explode(' ', $star);
                            //print_r($temp_star);die;
                            $films[$count]['stars'][$star_count]['name'] = ltrim($temp_star[1]);
                            $films[$count]['stars'][$star_count]['surname'] = ltrim($temp_star[2]);
                            $star_count++;
                        }
                        $flag = 0;
                        $count++;
                        break;
                    }
                }
            }
            //var_dump($films);die;
			$film_object = new Film(Init::getDb());
            foreach($films as $film){
                
                $film_object->create($film['title'], $film['release'], $film['format'], $film['stars']);
            }
            
		Init::redirect("/film/index");	
		}
		
    }
    
	public function indexAction($data = null){

        $film = new Film(Init::getDb());


		$column = "title";
		$new_order_by = "DESC";




		if(!empty($data['GET'])){
			$data = $data['GET'];

			if($data['order_by'] == "ASC"){
				$new_order_by = "DESC";
			}else{
				$new_order_by = "ASC";
			}
			$order_by = isset($data['order_by'])?$data['order_by']:'ASC';
			$column = isset($data['column'])?$data['column']:'title';
			$title = $data['title'];
            $star_name = $data['star_name'];
            if(isset($data['title'])){
                $this->data['films'] = $film->select()->join()->like(['title' => $title,'concat(name," ",surname)' => $star_name])->groupBy('film_id')->orderBy($order_by, $column)->run();
            }else{

                $this->data['films'] = $film->select()->join()->groupBy('film_id')->orderBy($order_by, $column)->run();
            }
            
            
            $this->data['order_by'] = $new_order_by;
		}else{
            $this->data['films'] = $film->select()->join()->groupBy('film_id')->run();
            
            $this->data['order_by'] = $new_order_by;
            //var_dump($this->data);die;
		}


		//print_r($title);die;
		
		//print_r($this->data);die;

		//print_r($this->data);die;
    }

	public function viewAction($data = null){
		$data = $data['Params'];

		$film = new Film(Init::getDb());
		$id = $data[0];
		$this->data = $film->view($id);

	}
    
    	public function deleteAction($data = null){
		//$data = $data['Params'];
        $film = new Film(Init::getDb());
		$id = $data['Params'][0];
        
        if(isset($data['POST'])){
            $data = $data['POST'];
            if($data['yes'] === 'Да'){
                $film->delete($id);
                Init::redirect("/film/index");
            }else{
                Init::redirect("/film/index");
            }
        }
		

	}
}