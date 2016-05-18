<?php
/**
 * Model class for User table
 * 
 * @author Agostino G. Manzi
 */
namespace MyBoard\Api\V10\Models{

use MyBoard\Api\Shared\Interfaces\Model;
use MyBoard\Api\Shared\Outcome;
use Exception;

	 class User implements Model{
		
		public function __construct(){
			$this->outc = new Outcome('','',null);
		}
		
		public $username = "";
		
		public $password = "";
		
		public $valid = "";
		
		public $active = "";
		
		public $id = "";
		
		public $dataModifica = "";
		
		public $dataInizio = "";
		
		public $JWT = "";
		
		private $outc;
		
		/**
		 * get Outcome of operations involving the Model instance
		 *
		 * 
		 * @return the outcome
		 */
		public function getOutcome(){
			
			return $outc;
		}
		
		/**
		 * set Outcome of operations involving the Model instance
		 *
		 * 
		 * @return the outcome
		 */
		public function setOutcome($type, $message, $exception){
			
			$outc = new Outcome($type, $message, $exception);
		
		}
		
	 }
 
 }

?>