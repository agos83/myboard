<?php
/**
 * Utility class
 *
 * @author Agostino G. Manzi
 */
namespace MyBoard\Api\Shared{

	 class Outcome{


		public function __construct($t, $m, $ex) {
			$this->type = $t;
			$this->message =$m;
			$this->exception = $ex;

		}


		public $type="";
		public $message="";
		public $exception=null;

	 }

 }

?>