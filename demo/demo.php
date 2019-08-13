<?php

require_once '../vendor/autoload.php' ;

require_once 'anno/LogBefore.php' ;
require_once 'anno/LogAfter.php' ;
require_once 'anno/Route.php' ;

use src\anno\LogBefore ;
use src\anno\LogAfter ;
use src\anno\Route ;
use Util\AnnotationRegistry ;
use Util\AnnotationContainer ;

class RouteHelper {
	
	protected $group_map = [] ;
	
	protected $route_map = [] ;
	
	public function setGroup($route, $method , $classname) {
		$this->group_map[$classname] = ['route' => $route, 'method' => $method] ;
	}
	
	public function setRoute($route, $method , $handler) {
		list($classname, $funcname) = $handler ;
		
		$group = ['route' => '', 'method' => 'GET'] ;
		if (isset($this->group_map[$classname])) {
			$group = $this->group_map[$classname] ;
		}
		
		$this->route_map[$classname . '::' . $funcname] = [
			'route' => $group['route'] . $route ,
			'method' => $method ? $method : $group['method'],
		] ;
	}
	
	// match route
	public function matchRoute($request_uri) {
		// ...
	}
	
	public function listRoute() {
		foreach($this->route_map as $k => $route) {
			echo $route['method'] . '  ' . $route['route'] . ' => '. $k. "\n" ;
		}
	}
}

/**
 * 
 * @LogBefore(message="hello")
 * @LogAfter(message="bye")
 * @Route(route="/test")
 */
class Test {
	
	/**
	 * @LogBefore(message="say")
	 * @Route(route="/say",method="GET")
	 */
	public function say() {
		echo "Hello, Yuhari." ;
	}
	
	/**
	 * @Route(route="/.+", method="POST")
	 */
	public function say2() {
		echo "Hello, Politt." ;
	}
} // END class 

$container = new AnnotationContainer() ;

$register = new AnnotationRegistry() ;

// 注释after log 
$register->setAnnotationMarker($container->get('src\anno\LogAfter'), function($anno){
	$target = $anno->getTarget() ;
	$type = array_shift($target) ;
	$message = $anno->message ;

	file_put_contents("./log.txt", date('Y-m-d H:i:s') . " After " . $type . " : " . implode('::', $target) . " [$message]\n", FILE_APPEND) ;
}) ;

$router = new RouteHelper() ;
// 注释路由
$register->setAnnotationMarker($container->get('src\anno\Route'), function($anno) use($router){
	$target = $anno->getTarget() ;
	$type = array_shift($target) ;
	
	if ($type == 'CLASS') {
		$router->setGroup($anno->route, $anno->method, $target[0]) ;
	}
	
	if ($type == 'METHOD') {
		$router->setRoute($anno->route, $anno->method, [$target[0], $target[1]]) ;
	}
}) ;

// 执行bootstrap annotation ,比如route 表
$register->runBootstrapClass(Test::class) ;
// 输出route map
$router->listRoute() ;

// 执行class annotation，比如类权限控制
$c = $register->runClass(Test::class) ;
// 执行method annotation， 比如接口请求日志、操作参数记录，接口登录判断等
$register->runMethod($c, 'say') ;
