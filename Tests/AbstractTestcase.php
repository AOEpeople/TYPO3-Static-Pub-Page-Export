<?php
/***************************************************************
 *  Copyright notice
 *
 *  (c) 2011 AOE media GmbH <dev@aoemedia.de>
 *  All rights reserved
 *
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

/**
 * Abstract base class for staticpub_pageexport Tests
 *
 * @package extracache
 * @subpackage Tests
 */
abstract class Tx_StaticpubPageexport_Tests_AbstractTestcase extends tx_phpunit_testcase {
	/**
	 * @var Tx_Extbase_Utility_ClassLoader
	 */
	private $classLoader;

	/**
	 * @string
	 */
	protected function loadClass($className) {
		$this->getClassLoader()->loadClass( $className );
	}

	/**
	 * @return Tx_Extbase_Utility_ClassLoader
	 */
	private function getClassLoader() {
		if($this->classLoader === NULL) {
			$this->classLoader = new Tx_Extbase_Utility_ClassLoader();
		}
		return $this->classLoader;
	}
}