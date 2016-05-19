<?php
/**
 * Interface for Data Access Layer class
 *
 * @author Agostino G. Manzi
 */
namespace MyBoard\Api\Shared\Interfaces{

use MyBoard\Api\Shared\Interfaces\Model;

	 interface DAL{

		/**
		 * Stores a Model record into DB table
		 *
         * @param Model $model the element to insert
         * @return Model the inserted element
		 */
		public function insert(Model $model);
		/**
		 * Updates a Model record into DB table
		 *
         * @param Model $model the element to update
         * @return Model the updated element
		 */
		public function update(Model $model);

		/**
		 * Finds a List of Model records from DB table
		 *
         * @param string $filters the filters to apply
         * @return Array the elements
		 */
		public function find($filters);
		/**
		 * Get a single Model instance
		 *
         * @param string $id record id
		 * @return Model Instance
		 */
		public function get($id);

        /**
		 * Deletes a Model from DB Table
		 *
         * @param Model $model the element to delete
		 * @return int operation status
		 */
		public function delete(Model $model);

	 }

 }

?>