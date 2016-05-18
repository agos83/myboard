<?php
/**
 * Interface for Data Access Layer class
 * 
 * @author Agostino G. Manzi
 */
namespace MyBoard\Api\Shared\Interfaces{

	 interface DAL{
		
		/**
		 * Stores a Model record into DB table
		 *
		 * @param Model the element to insert
		 * @return the inserted element
		 */
		public function insert($model);
		/**
		 * Updates a Model record into DB table
		 *
		 * @param Model the element to update
		 * @return the updated element
		 */
		public function update($model);
		
		/**
		 * Finds a List of Model records from DB table
		 *
		 * @param the filters to apply
		 * @return the element
		 */
		public function find($filters);
		/**
		 * Get a single Model instance
		 *
		 * @param record id
		 * @return Model Instance
		 */
		public function get($id);
		/**
		 * Deletes a Model from DB Table
		 *
		 * @param Model the element to delete
		 * @return boolean operation status
		 */
		public function delete($model);
		
	 }
 
 }

?>