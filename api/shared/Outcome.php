<?php
/**
 * Utility class
 * 
 * @author Agostino G. Manzi
 */
namespace MyBoard\Api\Shared{

	 class Outcome{
		
		
		public function __construct($t, $m, $ex) {        
			$type = $t;
			$message =$m;
			$exception = $ex;
		}
		
		
		public $type;
		public $message;
		public $exception;
		
	 }
 
 }

?>