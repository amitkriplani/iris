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
	protected $_basePath;
	protected $_controller;
	protected $_route;
	
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
		$this->initiateController ( $this->getRoute ()->getController () );
		$this->dispatch ( $this->getController (), $this->getRoute ()->getAction () );
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
	public function getRoute($path = null) {
		if (! $this->_route) {
			$queryStr = trim ( str_replace ( $this->getBasePath (), '', $_SERVER ['REQUEST_URI'] ), '/' );
			$parts = array_filter ( explode ( '/', $queryStr ) );
			switch (count ( $parts )) {
				case 0 : // using root url
					$controller = 'index';
					$action = 'index';
					$params = array();
					break;
				case 1 : // using controller name
					$controller = $parts[0];
					$action = 'index';
					$params = array();
					break;
				case 2 : // using controller+action name without params
					$controller = $parts[0];
					$action = $parts[1];
					$params = array();
					break;
				default : // using controller+action name with params
					$controller = $parts[0];
					$action = $parts[1];
					unset($parts[0]);
					unset($parts[1]);
					$params = array_values($parts);
				break;
			}
			$this->_route = new Iris_Route($controller, $action, $params);
		}
		return $this->_route;
	}
	public function getBasePath() {
		if (! $this->_basePath)
			$this->_basePath = str_replace ( 'index.php', '', $_SERVER ['PHP_SELF'] );
		return $this->_basePath;
	}
	protected function initiateController($name) {
		$this->setController ( $name );
		$this->initiateClass ( $this->getControllerPrefix () . $this->getController () );
	}
}
