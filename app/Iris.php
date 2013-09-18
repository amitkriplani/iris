<?php
/**
 * @package iris
 * @subpackage main
 * @version 1a
 * @name iris 
 * 
 * @author amit kriplani <contact@amitkriplani.com>
 */
class Iris {
	
	/**
	 * Constructor of the main class checks for all pre-requisites.
	 *
	 * @return void
	 */
	public function __construct() {
	}
	
	/**
	 * Setup the iris application.
	 * Based on available resources,
	 * select best communications method and make sure required
	 * configuration is available.
	 *
	 * @return Iris This instance
	 */
	public function setup() {
		return $this;
	}
	
	/**
	 * Run the main application.
	 * Process the incoming request and
	 * update state as required.
	 *
	 * @return void
	 */
	public function run() {
	}
}
