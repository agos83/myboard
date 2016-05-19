<?php
/**
 * TEST class for User model
 *
 * @author Agostino G. Manzi
 */

require '../../vendor/autoload.php';
use MyBoard\Api\V10\Models\User;
use MyBoard\Api\V10\Models\UserDAL;
echo 'START'.'<br/>';

echo base64_encode(openssl_random_pseudo_bytes(64)).'<br/>';


$usr = new User();
$usr->username= 'test';
$usr->password='testpwd';



$usrDal = new UserDAL();
echo 'USER INSERTED: '. $usrDal->insert($usr).'<br/>';

$users = $usrDal->find('');

echo print_r($users).'<br/>';

$usr = $usrDal->get(17);

 echo print_r($usr).'<br/>';

 $usr->password = 'testpwd2';

 echo 'USER UPDATED: '. $usrDal->update($usr).'<br/>';

 $usrupd = $usrDal->get(17);

 echo print_r($usrupd).'<br/>';

?>