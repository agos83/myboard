<?php
/**
 * TEST for Shared utilities
 *
 * @author Agostino G. Manzi
 */

require '../../vendor/autoload.php';
use MyBoard\Api\Shared\Utility;
echo 'START'.'<br/>';

$token = Utility::createToken('12');
echo $token.'<br/>';

echo print_r(json_decode($token)).'<br/>';

echo Utility::getUserIdFromToken(json_decode($token)->jwt).'<br/>';


?>