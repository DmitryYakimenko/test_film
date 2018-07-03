<?php
class Router{
    protected $uri;
    protected $controller;
    protected $action;
    protected $params;

 
    public function getUri()
    {
        return $this->uri;
    }

    public function getController()
    {
        return $this->controller;
    }

    public function getAction()
    {
        return $this->action;
    }

    public function getParams()
    {
        return $this->params;
    }


    public function __construct($uri){
        $this->uri = urldecode(trim($uri, '/'));

        $uri_parts = explode('?', $this->uri);
        // /controller/action/param1/param2/.../...
        $path = $uri_parts[0];
        $path_parts = explode('/', $path);
        if ( count($path_parts) ){
			
			if($path_parts[0]){
				$this->controller = array_shift($path_parts);
			}
			
			if($path_parts[0]){
				$this->action = array_shift($path_parts);
			}else{
				$this->action = 'index';
			}
			
			for($i=0; $i< count($path_parts); $i++){
				$this->params = $path_parts;
			}

        }
    }

}