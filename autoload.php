<?php
function __autoload($class_name){
		$controllers_path = dirname(__FILE__).'\controllers\\'.str_replace('controller', '', strtolower($class_name)).'.controller.php';
		$model_path = dirname(__FILE__).'\models\\'.strtolower($class_name).'.php';
		//var_dump($class_name);echo"<Br>";
		//var_dump($model_path);echo"<Br>";
		//var_dump(file_exists($model_path));echo"<Br>";
		if($class_name === 'Controller'){
			$controllers_path = dirname(__FILE__).'\controllers\controller.php';
		}
		if($class_name === 'View'){
			$view_path = dirname(__FILE__).'\views\view.php';
		}
		if ( file_exists($controllers_path) ){
			require_once($controllers_path);
		} elseif ( file_exists($model_path) ){
			require_once($model_path);
		} elseif ( file_exists($view_path) ){
			require_once($view_path);
		}else {
			throw new Exception('Failed to include class: '.$class_name);
		}
	}