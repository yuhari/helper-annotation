<?php
namespace src\anno ;

use Doctrine\Common\Annotations\Annotation\Required ;
use Util\Annotations\Before ;

/**
 * @Annotation
 * @Target({"CLASS", "METHOD"})
 */
class LogBefore extends Before {
	
	/**
	 *
	 * @Required()
	 * @var string
	 */
	public $message ;
	
	public function mark() :void {
		$target = $this->getTarget() ;
		$type = array_shift($target) ;
		$message = $this->message ;
		
		file_put_contents("./log.txt", date('Y-m-d H:i:s') . " Before " . $type . " : " . implode('::', $target) . " [$message]\n", FILE_APPEND) ;
		
	}
	
} // END class 