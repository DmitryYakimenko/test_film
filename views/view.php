<?php


class View
{

	protected $path;
	protected $data;
	protected $content;
	
	public function __construct($view_path, $data = []){
		$this->path = $view_path;
		$this->data = $data;
	}

	public function display(){
		$data = $this->data;
		
        ob_start();
        include($this->path);
        $content = ob_get_clean();
		return $content;
	}
	
	
   
}
?>