<?php
/**
 * @todo php doc
 * @author amit
 *
 */
class IrisUtility {
	const DIR_NAME_CODE_CUSTOM = 'custom'; // @todo move this to configuration
	const DIR_NAME_CODE_CONTRIB = 'contrib'; // @todo move this to configuration
	const DIR_NAME_CODE_CORE = 'core'; // @todo move this to configuration
	protected $_classFileExts = array ( // @todo move this to configuration
			'.php' 
	);
	protected static $_instance;
	public static function getInstance() {
		if (! IrisUtility::$_instance)
			IrisUtility::$_instance = new IrisUtility ();
		return IrisUtility::$_instance;
	}
	protected function __construct() {
	}
	public function autoload($class) {
		foreach ( $this->_classFileExts as $ext ) {
			
			$file = str_replace ( '_', DIRECTORY_SEPARATOR, $class ) . $ext;
			if (file_exists ( implode ( DIRECTORY_SEPARATOR, array (
					APP_ROOT,
					IrisUtility::DIR_NAME_CODE_CUSTOM,
					$file 
			) ) ))
				return require_once implode ( DIRECTORY_SEPARATOR, array (
						APP_ROOT,
						IrisUtility::DIR_NAME_CODE_CUSTOM,
						$file 
				) );
			if (file_exists ( implode ( DIRECTORY_SEPARATOR, array (
					APP_ROOT,
					IrisUtility::DIR_NAME_CODE_CONTRIB,
					$file 
			) ) ))
				return require_once implode ( DIRECTORY_SEPARATOR, array (
						APP_ROOT,
						IrisUtility::DIR_NAME_CODE_CONTRIB,
						$file 
				) );
			if (file_exists ( implode ( DIRECTORY_SEPARATOR, array (
					APP_ROOT,
					IrisUtility::DIR_NAME_CODE_CORE,
					$file 
			) ) ))
				return require_once implode ( DIRECTORY_SEPARATOR, array (
						APP_ROOT,
						IrisUtility::DIR_NAME_CODE_CORE,
						$file 
				) );
		}
	}
}
