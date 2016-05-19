<?php
/**
 * Controller class, manager of Account operations (Login, Register, Update Account)
 *
 * @author Agostino G. Manzi
 */
namespace MyBoard\Api\V10\Controllers{

use MyBoard\Api\V10\Models\User;
use MyBoard\Api\V10\Models\UserDAL;
use Myboard\Api\Shared\Utility;
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
			try{

				$user->username = $username;
				//la password arriverà come MD5 della password originale
				$user->password = $password;
				$user->active = 0;
				$user->valid = 1;

				$userDAL = new UserDAL();

				//aggiungere sanitize degli argomenti passati dall'esterno (injection)
				$foundUsr = $userDAL->find(' username='.$username);

				if($foundUsr != null || count($foundUsr)>0)
				{
					$user -> setOutcome(Utility::OUTC_WARNING,'01 - Username already taken, please try another one.', null);
					return $user;
				}

				$ret = $userDAL->insert($user);
				if($ret < 1){
					$user -> setOutcome(Utility::OUTC_ERROR,'02 - An error occurred while saving your data. Try again later.', null);
					return $user;
				}

				$userArr = $userDAL->find(' username='.$username.' AND valid=1 ');
				if($userArr == null || count($userArr)!=1)
				{
					$user -> setOutcome(Utility::OUTC_ERROR,'03 - An error occurred while saving your data. Try again later.', null);
					return $user;
				}

				$user = $userArr[0];
				$user -> setOutcome(Utility::OUTC_INFO,'Success.', null);
				return $user;
			}
			catch (Exception $ex){
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
			try{


				$userDAL = new UserDAL();

				//aggiungere sanitize degli argomenti passati dall'esterno (injection)
				$userArr = $userDAL->find(' username='.$username.' AND valid=1 AND active=0 ');

				if($userArr == null || count($userArr)!=1)
				{
					$user -> setOutcome(Utility::OUTC_WARNING,'01 - User not found, or account already actived.', null);
					return $user;
				}
				$user = $userArr[0];
				$user->active = 1;
				$ret = $userDAL->update($user);
				if($ret < 1){
					$user -> setOutcome(Utility::OUTC_ERROR,'02 - An error occurred while saving your data. Try again later.', null);
					return $user;
				}

				$user -> setOutcome(Utility::OUTC_INFO,'Success.', null);
				return $user;
			}
			catch (Exception $ex){
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
			try{


				$userDAL = new UserDAL();

				//aggiungere sanitize degli argomenti passati dall'esterno (injection)
				$userArr = $userDAL->find(' username='.$username.' AND password='.$password.' AND valid = 1 AND active = 1 ');

				if($userArr == null || count($userArr)!=1)
				{
					$user -> setOutcome(Utility::OUTC_ERROR,'01 - Username not found or wrong password.', null);
					return $user;
				}

                $user = $userArr[0];
				//integrata la generazione del token JWT
				$user->JWT = Utility::createToken($user->id);


				$user -> setOutcome(Utility::OUTC_INFO,'Success.', null);
				return $user;
			}
			catch (Exception $ex){
				//Aggiungere sistema di Log per gestione errori
				$user -> setOutcome(Utility::OUTC_EXCEPTION,'04 - An error occurred while saving your data. Try again later.', $ex);
				return $user;
			}
		}

		/**
		 * Check the key validity, to be used to authenticate API calls
		 * this will not be exposed as an API
		 *
         * @param string $userdId the user id
         * @param string $jwt the key to match
		 * @return int 1 if allowed 0 otherwise
		 */
		public function verifyAuthKey($userdId, $jwt)
		{


            return 0;
		}

		/**
		 * Updates a user Account
		 *
         * @param User $user the element to update
		 * @return User the updated element
		 */
		public function update($user)
		{
            $user = new User();

            return $user;
		}

		/**
		 * Deletes a user Account
		 *
         * @param User $user user the element to delete
		 * @return int 1 if ok 0 if errors
		 */
		public function delete($user)
		{
            return 0;
		}

	 }

}


?>