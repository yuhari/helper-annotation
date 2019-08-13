<?php
namespace src\anno ;

use Doctrine\Common\Annotations\Annotation\Required ;
use Doctrine\Common\Annotations\Annotation\Enum ;
use Util\Annotations\Bootstrap ;

/**
 * @Annotation
 * @Target({"CLASS", "METHOD"})
 */
class Route extends Bootstrap {
	
	/**
	 *
	 * @Required()
	 * @var string
	 */
	public $route;
	
	/**
	 *
	 * @Enum({"POST","GET","PUT","DELETE"})
	 * @var string
	 */
	public $method;
	
} // END class 