<?php
namespace src\anno ;

use Doctrine\Common\Annotations\Annotation\Required ;
use Util\Annotations\After ;

/**
 * @Annotation
 * @Target({"CLASS", "METHOD"})
 */
class LogAfter extends After {
	
	/**
	 *
	 * @Required()
	 * @var string
	 */
	public $message ;
	
} // END class 