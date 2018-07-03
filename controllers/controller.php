<?php

class Controller{
	
	protected $data;
	protected $view_path;
	
	public function getData(){
		return $this->data;
	}
    
    public function indexAction(){
		
		Init::redirect('/film/index');
    }
}