<?php
/**
 * Utility class
 *
 * @author Agostino G. Manzi
 */
namespace MyBoard\Api\Shared{
    require_once 'Conf.php';
    use Firebase\JWT\JWT;
    use Firebase\JWT\ExpiredException;
    use Firebase\JWT\BeforeValidException;
    use Firebase\JWT\SignatureInvalidException;
    use MyBoard\Api\Shared\Outcome;

	 class Utility{

		const OUTC_INFO = 'INFO';
		const OUTC_ERROR = 'ERROR';
		const OUTC_WARNING = 'WARNING';
		const OUTC_EXCEPTION = 'EXCEPTION';

        const ACTIVATION_URL = 'http://localhost/myboard/api/v10/account/activate';

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

        public static function getUserIdFromToken($token){

            $secretKey = base64_decode(SECRET);
            $token = JWT::decode($token, $secretKey, array('HS512'));
            return $token->data->userId;

        }

        public static function validateToken($token){

            $secretKey = base64_decode(SECRET);
            $token = JWT::decode($token, $secretKey, array('HS512'));
            return $token;

        }

        public static function getKey($input){

            return md5($input.SECRET);

        }

	 }

 }

?>