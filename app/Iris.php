<?php
/**
 *
 * @package iris
 * @subpackage main
 * @name iris
 *      
 * @author amit kriplani <contact@amitkriplani.com>
 */
class Iris {
	protected static $_instance;
	
	/**
	 * Save mode environment for easy access
	 *
	 * @var String
	 */
	protected static $_mode = 'live';
	
	/**
	 *
	 * @return the $_instance
	 */
	public static function getInstance() {
		if (! Iris::$_instance)
			Iris::$_instance = new Iris ();
		return Iris::$_instance;
	}
	
	/**
	 *
	 * @return the $_mode
	 */
	public static function getMode() {
		return Iris::$_mode;
	}
	
	/**
	 *
	 * @param string $_mode        	
	 */
	protected static function setMode($_mode) {
		Iris::$_mode = $_mode;
	}
	
	/**
	 * Constructor of the main class checks for all pre-requisites.
	 *
	 * @return void
	 */
	protected function __construct() {
		if (( float ) PHP_VERSION < 5.3)
			throw new Exception ( 'Iris requires PHP version 5.3 or above.' ); // @todo change to IrisException
				                                                                   
		// @todo check other requirements like internet connection and sendmail
	}
	
	/**
	 * Setup the iris application.
	 * Based on available resources,
	 * select best communications method and make sure required
	 * configuration is available.
	 *
	 * @return Iris This instance
	 */
	public function setup($mode) {
		Iris::setMode ( $mode );
		Iris::setupAutoloading ();
		Iris::bootstrap ();
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
		die ( Iris::getMode () );
	}
	protected static function setupAutoloading() {
		require_once 'IrisUtility.php';
		spl_autoload_register ( array (
				IrisUtility::getInstance (),
				'autoload' 
		) );
	}
	protected static function bootstrap() {
		if (! Iris::getMode ())
			throw new Exception ( 'Cannot bootstrap without "mode"' ); // @todo change to IrisException
		
		$bootstrap = new Bootstrap ();
		$bootstrap->bootstrap ( Iris::getMode () );
	}
}
