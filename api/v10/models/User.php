<?php
/**
 * Model class for User table
 * 
 * @author Agostino G. Manzi
 */
namespace MyBoard\Api\V10\Models{

use MyBoard\Api\Shared\Interfaces\Model;
use Exception;

	 class User implements Model{
		
		public function __construct(){
			
		}
		
		public $username = "";
		
		public $password = "";
		
		public $valid = "";
		
		public $active = "";
		
		public $id = "";
		
		public $dataModifica = "";
		
		public $dataInizio = "";
		
	 }
 
 }

?>