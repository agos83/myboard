<?php

require '../vendor/autoload.php';
$app = new Slim\App();

use MyBoard\Api\Middleware\Authentication;
use MyBoard\Api\V10\Controllers\Account;
use MyBoard\Api\V10\Models\User;
use MyBoard\Api\Shared\Outcome;
use MyBoard\Api\Shared\Utility;
use Slim\Http\Request;
use Slim\Http\Response;



$app->get('/account/login', function (Request $request,Response $response, $args) {

     $newResponse = $response->withStatus(200);
    $accCtrl = new Account();
    $username = $request->getParam('usr');
    $password = $request->getParam('pwd');

    $usr = $accCtrl->login($username, $password);

    $outc = $usr->getOutcome();

    if( $outc->type == Utility::OUTC_WARNING){
        $newResponse = $response->withStatus(400);
    }
    elseif( $outc->type == Utility::OUTC_ERROR){
        $newResponse = $response->withStatus(401);
    }
    elseif( $outc->type == Utility::OUTC_EXCEPTION){
        $newResponse = $response->withStatus(500);
    }

    $result = new User();
    $result->JWT = $usr->JWT;
    $result->setOutcomeInstance($usr->getOutcome());

    $newResponse->write(json_encode($result));
    return $newResponse;
});

$app->put('/account/activate', function (Request $request,Response $response, $args) {

     $newResponse = $response->withStatus(200);
    $accCtrl = new Account();
    $username = $request->getParam('usr');
    $key = $request->getParam('key');

    $usr = $accCtrl->activate($username, $key);

    $outc = $usr->getOutcome();

    if( $outc->type == Utility::OUTC_WARNING){
        $newResponse = $response->withStatus(400);
    }
    elseif( $outc->type == Utility::OUTC_ERROR){
        $newResponse = $response->withStatus(401);
    }
    elseif( $outc->type == Utility::OUTC_EXCEPTION){
        $newResponse = $response->withStatus(500);
    }

    $newResponse->write(json_encode($outc));
    return $newResponse;
});


//REGISTER NEW USER
$app->post('/user', function (Request $request,Response $response, $args) {

     $newResponse = $response->withStatus(200);

    $accCtrl = new Account();
    $username = $request->getParam('usr');
    $password = $request->getParam('pwd');

    $usr = $accCtrl->register($username, $password);

    $outc = $usr->getOutcome();

    if( $outc->type == Utility::OUTC_WARNING){
        $newResponse = $response->withStatus(400);
    }
    elseif( $outc->type == Utility::OUTC_ERROR){
        $newResponse = $response->withStatus(401);
    }
    elseif( $outc->type == Utility::OUTC_EXCEPTION){
        $newResponse = $response->withStatus(500);
    }

    $newResponse->write(json_encode($usr->getOutcome()));
    return $newResponse;
});

//update user
$app->put('/user', function (Request $request, Response $response, $args) {
    $newResponse = $response->withStatus(200);
    $accCtrl = new Account();
    $usrId = $request->getParam('usrid');
    $oldPwd = $request->getParam('oldpwd');
    $newPwd = $request->getParam('newpwd');
    $outc = $accCtrl->changePassword($usrId, $oldPwd, $newPwd);
    if( $outc->type == Utility::OUTC_WARNING){
        $newResponse = $response->withStatus(400);
    }
    elseif( $outc->type == Utility::OUTC_ERROR){
        $newResponse = $response->withStatus(401);
    }
    elseif( $outc->type == Utility::OUTC_EXCEPTION){
        $newResponse = $response->withStatus(500);
    }
    $newResponse->write(json_encode($outc));
    return $newResponse;
})->add(new \MyBoard\Api\Middleware\Authentication());

//delete user
$app->delete('/user', function (Request $request, Response $response, $args) {
    $newResponse = $response->withStatus(200);
    $accCtrl = new Account();
    $usrId = $request->getParam('usrid');
    $password = $request->getParam('pwd');
    $outc = $accCtrl->delete($usrId, $password);
    if( $outc->type == Utility::OUTC_WARNING){
        $newResponse = $response->withStatus(400);
    }
    elseif( $outc->type == Utility::OUTC_ERROR){
        $newResponse = $response->withStatus(401);
    }
    elseif( $outc->type == Utility::OUTC_EXCEPTION){
        $newResponse = $response->withStatus(500);
    }
    $newResponse->write(json_encode($outc));
    return $newResponse;
})->add(new \MyBoard\Api\Middleware\Authentication());

//find
$app->get('/user', function (Request $request, Response $response, $args) {
    $newResponse = $response->withStatus(200);
    $accCtrl = new Account();
   //TODO implementare la find di utenti per username
    //Se non viene passato username ritorna tutti gli utenti
    $users = null; //$accCtrl->delete($usrId, $password);
    $newResponse->write('TEST FIND');
    return $newResponse;
})->add(new \MyBoard\Api\Middleware\Authentication());

$app->run();

?>