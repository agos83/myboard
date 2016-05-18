<?php
/**
 * Interface for Model classes
 * 
 * @author Agostino G. Manzi
 */
namespace MyBoard\Api\Shared\Interfaces{
	
use MyBoard\Api\Shared\Outcome;

	 interface Model{
		/**
		 * get Outcome of operations involving the Model instance
		 *
		 * 
		 * @return the outcome
		 */
		public function getOutcome();
		
		/**
		 * set Outcome of operations involving the Model instance
		 *
		 * @param type the outcome: 'INFO', 'WARNING', 'ERROR', 'EXCEPTION'
		 * @param message the outcome message
		 * @param exception the exception when present
		 * @return the outcome
		 */
		public function setOutcome($type, $message, $exception);
	 }
 
 }

?>