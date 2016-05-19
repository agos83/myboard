<?php
/**
 * Interface for Model classes
 *
 * @author Agostino G. Manzi
 */
namespace MyBoard\Api\Shared\Interfaces{

use MyBoard\Api\Shared\Outcome;
use Exception;

	 interface Model{
		/**
		 * get Outcome of operations involving the Model instance
		 *
		 *
		 * @return Outcome the outcome
		 */
		public function getOutcome();

		/**
		 * set Outcome of operations involving the Model instance
		 *
         * @param string $type the outcome: 'INFO', 'WARNING', 'ERROR', 'EXCEPTION'
         * @param string $message the outcome message
         * @param Exception $exception the exception when present
		 * @return void
		 */
		public function setOutcome($type, $message, $exception);
	 }

 }

?>