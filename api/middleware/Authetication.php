<?php
/**
 * A Slim Middleware for light authentication
 * 
 * @author Agostino G. Manzi
 */
namespace MyBoard\Middleware;

 class Authenticaition extends \Slim\Middleware{
	
	
	function __construct() {        
		
    }
	
	
	function call(){
		//Optionally call the next middleware
        $this->next->call();
	}
 
 }

?>