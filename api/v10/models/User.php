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
		 * @return Outcome the outcome
         */
		public function getOutcome(){

			return $this->outc;
		}

		/**
         * set Outcome of operations involving the Model instance
         *
         * @param string $type the outcome: 'INFO', 'WARNING', 'ERROR', 'EXCEPTION'
         * @param string $message the outcome message
         * @param \Exception $exception the exception when present
         * @return void
         */
		public function setOutcome($type, $message, $exception){

			$this->outc = new Outcome($type, $message, $exception);

		}

	 }

 }

?>