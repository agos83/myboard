<?php
/**
 * A Slim Middleware for light authentication
 *
 * @author Agostino G. Manzi
 */
namespace MyBoard\Api\Middleware;

 class Authentication {

     /**
      * My Auth middleware class
      *
      * @param  \Psr\Http\Message\ServerRequestInterface $request  PSR7 request
      * @param  \Psr\Http\Message\ResponseInterface      $response PSR7 response
      * @param  callable                                 $next     Next middleware
      *
      * @return \Psr\Http\Message\ResponseInterface
      */
     public function __invoke($request, $response, $next)
     {
         $response->getBody()->write('BEFORE');
         

         return $next($request, $response);
     }

 }

?>