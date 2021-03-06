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

	 class User implements Model, \JsonSerializable{

		public function __construct(){

		}

		public $username = "";

		public $password = "";

		public $valid = "";

		public $active = "";

		public $id = "";

		public $dataModifica = "";

		public $dataInizio = "";

		public $JWT = "";

		private $outc = null;

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

			$this->outc =  new Outcome($type, $message, $exception);
		}

        /**
         * set Outcome of operations involving the Model instance
         *
         * @param Outcome the instance to set
         * @return void
         */
		public function setOutcomeInstance(Outcome $outcome){

			$this->outc = $outcome;
		}


        public function JsonSerialize()
        {
            $vars = get_object_vars($this);

            return $vars;
        }

	 }

}

?>