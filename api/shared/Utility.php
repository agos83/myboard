<?php
/**
 * Utility class
 *
 * @author Agostino G. Manzi
 */
namespace MyBoard\Api\Shared{
    use Firebase\JWT\JWT;
    use Firebase\JWT\ExpiredException;
    use Firebase\JWT\BeforeValidException;
    use Firebase\JWT\SignatureInvalidException;

	 class Utility{

		const OUTC_INFO = 'INFO';
		const OUTC_ERROR = 'ERROR';
		const OUTC_WARNING = 'WARNING';
		const OUTC_EXCEPTION = 'EXCEPTION';

		public function __construct() {

		}

		public static function createToken($userId){

			$tokenId    = base64_encode(mcrypt_create_iv(32));
			$issuedAt   = time();
			$notBefore  = $issuedAt;
			$expire     = $notBefore + EXP_SECS;
			$serverName = SERVER;

			$data = [
				'iat'  => $issuedAt,
				'jti'  => $tokenId,
				'iss'  => $serverName,
				'nbf'  => $notBefore,
				'exp'  => $expire,
				'data' => [
					'userId'   => $userId
				]
			];

			$secretKey = base64_decode(SECRET);

			$jwt = JWT::encode(
				$data,
				$secretKey,
				'HS512'
				);

			$unencodedArray = ['jwt' => $jwt];
			return json_encode($unencodedArray);


		}

        public static function validateToken($userId, $token){
            try{

                $secretKey = base64_decode(SECRET);
                $token = JWT::decode($jwt, $secretKey, array('HS512'));
                return true;
            }
            catch(SignatureInvalidException ex){
                return false;
            }
        }

	 }

 }

?>