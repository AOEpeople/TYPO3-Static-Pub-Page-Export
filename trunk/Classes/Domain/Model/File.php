<?php
/***************************************************************
 * Copyright notice
 *
 * (c) 2011 AOE media GmbH <dev@aoemedia.de>
 * All rights reserved
 *
 *
 * This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

/**
 * VALUE-object
 * 
 * @package staticpub_pageexport
 */
class Tx_StaticpubPageexport_Domain_Model_File {
	/**
	 * @var string
	 */
	private $name;
	/**
	 * this is the path on the server, where the file is
	 * 
	 * @var string
	 */
	private $originalPath;
	/**
	 * this is the path, which must be used in ZIP-file
	 * 
	 * @var string
	 */
	private $relativePath;

	/**
	 * @param string $name
	 * @param string $originalPath
	 * @param string $relativePath
	 */
	public function __construct($name, $originalPath, $relativePath) {
		$this->name = $name;
		$this->originalPath = $originalPath;
		$this->relativePath = $relativePath;
	}

	/**
	 * @return string
	 */
	public function getName() {
		return $this->name;
	}
	/**
	 * @return string
	 */
	public function getOriginalPath() {
		return $this->originalPath;
	}
	/**
	 * @return string
	 */
	public function getRelativePath() {
		return $this->relativePath;
	}
}