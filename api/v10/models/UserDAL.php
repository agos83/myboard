<?php
/**
 * Model class for User table
 *
 * @author Agostino G. Manzi
 */
namespace MyBoard\Api\V10\Models{

use MyBoard\Api\Shared\Interfaces\DAL;
use MyBoard\Api\Shared\Database;
use MyBoard\Api\Shared\Interfaces\Model;
use Exception;

	 class UserDAL implements DAL{

		const TAB_NAME = 'users';
		const INSERT_COLS = "(username, password, valid, active) VALUES (:usr, :pwd, :valid, :active)";

		const UPDATE_COLS = "SET username = :usr, valid = :valid, active= :active, password = :pwd, dataModifica = NOW() ";
		const UPDATE_WHERE = "WHERE id = :id";
		const DELETE_SET = "SET valid = 0";
		const DELETE_WHERE = "WHERE id = :id";

		public function __construct(){


		}


		public function insert(Model $model){
			try
			{
				$stmt = Database::getConnection()->prepare('INSERT INTO '.self::TAB_NAME.' '.self::INSERT_COLS.' ');

				$stmt->execute(array(
					':usr' => $model->username,
					':pwd' => $model->password,
					':valid' => $model->valid,
					':active' => $model->active
				));

				return $stmt->rowCount();

			} catch(Exception $e) {
				//Aggiungere sistema di Log per gestione errori
				return 0;
			}
		}
		public function update(Model $model){
			try
			{
				$stmt = Database::getConnection()->prepare('UPDATE '.self::TAB_NAME.' '.self::UPDATE_COLS.' '.self::UPDATE_WHERE);

				$stmt->execute(array(
					':usr' => $model->username,
					':pwd' => $model->password,
					':valid' => $model->valid,
					':active' => $model->active,
					':id'=> $model->id
				));

				return $stmt->rowCount();

			} catch(Exception $e) {
				//Aggiungere sistema di Log per gestione errori
				return 0;
			}
		}
		public function find($filters){
			try
			{

				$and = '';
				if(!empty($filters))
					$and = ' AND ';
				//CAMBIARE LOGICA DI BINDING DEI FILTRI (Array)
				$stmt = Database::getConnection()->prepare('SELECT * FROM '.self::TAB_NAME.' WHERE '.$filters.$and. ' 1 = 1');
                //echo 'SELECT * FROM '.self::TAB_NAME.' WHERE '.$filters.$and. ' 1 = 1';
				$stmt->execute();
				return $stmt->fetchAll(Database::FETCH_CLASS, 'MyBoard\Api\V10\Models\User');

			} catch(Exception $e) {
				//Aggiungere sistema di Log per gestione errori
				return null;
			}
		}
		public function get($id){
			try
			{
				$stmt = Database::getConnection()->prepare('SELECT * FROM '.self::TAB_NAME.' WHERE id = :id LIMIT 1');

				$stmt->bindParam(':id', $id);
				$stmt->execute();
				return $stmt->fetchObject('MyBoard\Api\V10\Models\User');

			} catch(Exception $e) {
				//Aggiungere sistema di Log per gestione errori
				return null;
			}
		}

		public function delete(Model $model){
			try
			{
				$stmt = Database::getConnection()->prepare('UPDATE '.self::TAB_NAME.' '.self::DELETE_SET.' '.self::DELETE_WHERE);

				$stmt->bindParam(':id', $model->id);
				$stmt->execute();

				return $stmt->rowCount();

			} catch(Exception $e) {
				//Aggiungere sistema di Log per gestione errori
				return 0;
			}
		}

        /**
         * Begin Db Transaction
         *
         *
         * @return void
         */
		public function beginTransaction(){
            //echo 'BEGIN';
            Database::getConnection()->beginTransaction();
        }

        /**
         * Commit Db Transaction
         *
         *
         * @return void
         */
		public function commit(){
            //echo 'COMMIT';
            Database::getConnection()->commit();
        }

        /**
         * Rollback Db Transaction
         *
         *
         * @return void
         */
		public function rollback(){
            //echo 'ROLLBACK';
            Database::getConnection()->rollBack();
        }

	 }

}

?>