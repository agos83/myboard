<?php
/**
 * Controller class, manager of Account operations (Login, Register, Update Account)
 *
 * @author Agostino G. Manzi
 */

namespace MyBoard\Api\V10\Controllers{

use MyBoard\Api\Shared\Utility;
use MyBoard\Api\V10\Models\User;
use MyBoard\Api\V10\Models\UserDAL;
use MyBoard\Api\Shared\Outcome;
use Exception;

	 class Account{


		public function __construct(){

		}

		/**
		 * Create a new User Account in the system
		 *
		 * @param string $username of the element to insert
		 * @param string $password of the element to insert
		 * @return User inserted element
		 */
		public function register($username, $password)
		{
            $user = new User();
            $userDAL = new UserDAL();
			try{

				$user->username = $username;
				//la password arriverà come MD5 della password originale
				$user->password = $password;
				$user->active = 0;
				$user->valid = 1;

                $userDAL->beginTransaction();

				//aggiungere sanitize degli argomenti passati dall'esterno (injection)
				$foundUsr = $userDAL->find(' username= \''.$username.'\' AND valid=1 ');

				if($foundUsr != null || count($foundUsr)>0)
				{

                    $userDAL->rollback();
					$user->setOutcome(Utility::OUTC_WARNING,'01 - Username already used by someone else, please try another one.', null);
                                     
					return $user;
				}

				$ret = $userDAL->insert($user);
				if($ret < 1){
                    $userDAL->rollback();
					$user -> setOutcome(Utility::OUTC_ERROR,'02 - An error occurred while saving your data. Try again later.', null);
					return $user;
				}

				$userArr = $userDAL->find(' username=\''.$username.'\' AND valid=1 ');
				if($userArr == null || count($userArr)!=1)
				{
                    $userDAL->rollback();
					$user -> setOutcome(Utility::OUTC_ERROR,'03 - An error occurred while saving your data. Try again later.', null);
					return $user;
				}

                //Aggiungere invio e-mail per attivazione account.
                $key = Utility::getKey($username.$password);
                //TODO: sendmail($username, 'Text');
                $to      = $username;
                $subject = 'MyBoard Account Activation';
                $message = 'Hello, \r\n Before you can login you have to activate your account by clicking the link below:\r\n'.
                    Utility::ACTIVATION_URL.'?u='.$username.'&k='.$key;
                $headers = 'From: webmaster@myboard.com' . "\r\n" .
                    'Reply-To: webmaster@myboard.com' . "\r\n" .
                    'X-Mailer: PHP/' . phpversion();
                echo $key.'<br/>';
                mail($to, $subject, $message, $headers);
                $user->JWT = $key;
                $userDAL->commit();
				$user = $userArr[0];
				$user -> setOutcome(Utility::OUTC_INFO,'Success.', null);
				return $user;
			}
			catch (Exception $ex){
                $userDAL->rollback();
				//Aggiungere sistema di Log per gestione errori
				$user -> setOutcome(Utility::OUTC_EXCEPTION,'04 - An error occurred while saving your data. Try again later.', $ex);
				return $user;
			}
		}

		/**
		 * Activates new User Account in the system
		 *
         * @param string $username of the element to insert
         * @param string $key a unique security key
         * @return User the inserted element
		 */
		public function activate($username, $key)
		{
            $user = new User();
            $userDAL = new UserDAL();
			try{


                $userDAL->beginTransaction();
				//aggiungere sanitize degli argomenti passati dall'esterno (injection)
				$userArr = $userDAL->find(' username=\''.$username.'\' AND valid=1 AND active=0 ');

				if($userArr == null || count($userArr)!=1)
				{
                    $userDAL->rollback();
					$user -> setOutcome(Utility::OUTC_WARNING,'01 - User not found, or account already activated.', null);
					return $user;
				}
				$user = $userArr[0];

                $validKey = Utility::getKey($username.$user->password);

                if($key!=$validKey){
                    $userDAL->rollback();
                    $user -> setOutcome(Utility::OUTC_ERROR,'02 - Invalid activation key.', null);
					return $user;
                }

				$user->active = 1;
				$ret = $userDAL->update($user);
				if($ret < 1){
                    $userDAL->rollback();
					$user -> setOutcome(Utility::OUTC_ERROR,'03 - An error occurred while saving your data. Try again later.', null);
					return $user;
				}

                $userDAL->commit();
				$user -> setOutcome(Utility::OUTC_INFO,'Success.', null);
				return $user;
			}
			catch (Exception $ex){
                $userDAL->rollback();
				//Aggiungere sistema di Log per gestione errori
				$user -> setOutcome(Utility::OUTC_EXCEPTION,'04 - An error occurred while saving your data. Try again later.', $ex);
				return $user;
			}
		}

		/**
		 * Check the login for the user and returns a key
		 *
         * @param string $username of the user to login
         * @param string $password of the user to login
		 * @return User an authentication key that can be used by the caller
		 */
		public function login($username, $password)
		{
            $user = new User();
            $userDAL = new UserDAL();
			try{

                $userDAL->beginTransaction();


				//aggiungere sanitize degli argomenti passati dall'esterno (injection)
				$userArr = $userDAL->find(' username=\''.$username.'\' AND password=\''.$password.'\' AND valid = 1 AND active = 1 ');

				if($userArr == null || count($userArr)!=1)
				{
                    $userDAL->rollback();
					$user -> setOutcome(Utility::OUTC_ERROR,'01 - Username not found or wrong password.', null);
					return $user;
				}

                $user = $userArr[0];
				//integrata la generazione del token JWT
				$user->JWT = Utility::createToken($user->id);

                $userDAL->commit();
				$user -> setOutcome(Utility::OUTC_INFO,'Success.', null);
				return $user;
			}
			catch (Exception $ex){
                $userDAL->rollback();
				//Aggiungere sistema di Log per gestione errori
				$user -> setOutcome(Utility::OUTC_EXCEPTION,'04 - An error occurred while saving your data. Try again later.', $ex);
				return $user;
			}
		}

		/**
		 *  Get a User from the jwt token, this method will not be exposed
		 *
         * @param string $jwt the key to verify
		 * @return User the user identified by token
		 */
		public static function getUserFromAuthToken($jwt)
		{
            $user = new User();
            try{
                $userid = Utility::getUserIdFromToken($jwt);
                $userDAL = new UserDAL();
                $userFound = $userDAL->get($userid);
                if($userFound == null){
                    $user -> setOutcome(Utility::OUTC_ERROR,'01 - Authentication error, invalid token.', null);
					return $user;
                }

                $user = $userFound;
            }
            catch (Exception $exception)
            {
            	//Aggiungere sistema di Log per gestione errori
				$user -> setOutcome(Utility::OUTC_EXCEPTION,'02 - Authentication error, invalid token.', $exception);
				return $user;
            }

            return $user;
		}

		/**
		 * Updates a user password
		 *
         * @param string $userId the user id to update
         * @param string $oldPwd the old password
         * @param string $newPwd the new password
		 * @return Outcome the operation outcome
		 */
		public function changePassword($userId, $oldPwd, $newPwd)
		{
            $result = new Outcome(Utility::OUTC_INFO, 'Success.', null);
            $userDAL = new UserDAL();
			try{

                $userDAL->beginTransaction();

                if(empty($userId)){
                    $userDAL->rollback();
                    $result = new Outcome(Utility::OUTC_ERROR,'01 - Invalid input.', null);
					return $result;
                }



                $userArr = $userDAL->find(' id=\''. $userId.'\' AND valid=1 AND password=\''.$oldPwd.'\'');
                if($userArr == null || count($userArr)!=1)
				{
                    $userDAL->rollback();
                    $result = new Outcome(Utility::OUTC_ERROR,'02 - Invalid input.', null);
					return $result;
                }

                //Gli utenti possono cambiare solo la password del proprio account
                $userFound = $userArr[0];
                $userFound -> password = $newPwd;

				$affected = $userDAL->update($userFound);

				if($affected != 1)
				{
                    $userDAL->rollback();
					$result = new Outcome(Utility::OUTC_ERROR,'03 - An error occurred while saving your data. Try again later.', null);
					return $result;
				}

                $userDAL->commit();
				return $result;
			}
			catch (Exception $ex){
                $userDAL->rollback();
				//Aggiungere sistema di Log per gestione errori
				$result = new Outcome(Utility::OUTC_EXCEPTION,'04 - An error occurred while saving your data. Try again later.', $ex);
				return $result;
			}
		}

		/**
		 * Deletes a user Account
		 *
         * @param string $userId the id of the account to delete
		 * @return Outcome opertation outcome
		 */
		public function delete($userId)
		{
            $result = new Outcome(Utility::OUTC_INFO, 'Success.', null);
            $userDAL = new UserDAL();

			try{

                $userDAL->beginTransaction();

                if(empty($userId)){
                    $userDAL->rollback();
                    $result = new Outcome(Utility::OUTC_ERROR,'01 - An error occurred while saving your data. Try again later.', null);
					return $result;
                }


                $user = new User();
                $user->id = $userId;

				$affected = $userDAL->delete($user);

				if($affected != 1)
				{
                    $userDAL->rollback();
					$result = new Outcome(Utility::OUTC_ERROR,'03 - An error occurred while deleting your account. Try again later.', null);
					return $result;
				}

                $userDAL->commit();
				return $result;
			}
			catch (Exception $ex){
                $userDAL->rollback();
				//Aggiungere sistema di Log per gestione errori
				$result = new Outcome(Utility::OUTC_EXCEPTION,'04 - An error occurred while deleting your account. Try again later.', $ex);
				return $result;
			}
		}

	 }

}


?>