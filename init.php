<?php
include 'db/database.php';
include 'router.php';

class Init{
	
	
	
	
    protected static $router;
    public static $db;
	

    public static function getRouter(){
        return self::$router;
    }
	
	public static function getDb(){
        return self::$db;
    }
    public static function redirect($url){
        header('Location: '.$url);
    }
	
    public static function run($uri){
		
		
		
        self::$router = new Router($uri);
        self::$db = new Database();

        $controller_name = self::$router->getController();
		$controller_class = ucfirst(self::$router->getController()).'Controller';
        if(self::$router->getAction()){
		  $controller_action = self::$router->getAction().'Action';
        }else{
           $controller_action = 'indexAction'; 
        }
		
		$controller_object = new $controller_class();
		
        if(!empty($_FILES)){
			$data['FILES'] = $_FILES;
		}		
		if(!empty($_POST)){
			$data['POST'] = $_POST;
		}
		if(!empty($_GET)){
			$data['GET'] = $_GET;
		}
		if(!empty(self::$router->getParams())){
			$data['Params'] = self::$router->getParams();
		}
		$controller_object->$controller_action($data);
		$view_path = "views/".$controller_name."/".self::$router->getAction().".html";
		
		$view_object = new View($view_path,$controller_object->getData());
		$content = $view_object->display();
		
		$view_defoult = new View('views/defoult.html', $content);
		echo $view_defoult->display();
		

		
		
    }
}