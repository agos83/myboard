<?php
/**
 * TEST for Account contoller
 *
 * @author Agostino G. Manzi
 */

require '../../vendor/autoload.php';
use MyBoard\Api\V10\Controllers\Account;
use MyBoard\Api\V10\Models\User;
use MyBoard\Api\Shared\Outcome;
use MyBoard\Api\Shared\Utility;
echo 'START'.'<br/>';


$accountCntrl = new Account();
$user = $accountCntrl->register('agos83@gmail.com','MD5ofPassword');

echo '----REGISTRAZIONE---- <br/>';
echo print_r($user).'<br/> <br/>';

echo '----ATTIVAZIONE---- <br/>';
$user = $accountCntrl->activate('agos83@gmail.com','7139cff59eed7231f857c84682636ebc');
echo print_r($user).'<br/> <br/>';

echo '----LOGIN---- <br/>';
$user = $accountCntrl->login('agos83@gmail.com','MD5ofPassword');
echo print_r($user).'<br/> <br/>';

echo '----GET USER FROM JWT---- <br/>';
$user = Account::getUserFromAuthToken(json_decode($user->JWT)->jwt);
echo print_r($user).'<br/> <br/>';

echo '----CHANGE PASSWORD---- <br/>';
$res = $accountCntrl->changePassword($user->id,'MD5ofPassword', 'NEWMD5_Password');
echo print_r($res).'<br/> <br/>';

echo '----LOGIN---- <br/>';
$user = $accountCntrl->login('agos83@gmail.com','NEWMD5_Password');
echo print_r($user).'<br/> <br/>';

echo '----DELETE USER---- <br/>';
$res = $accountCntrl->delete($user->id);
echo print_r($res).'<br/> <br/>';

?>