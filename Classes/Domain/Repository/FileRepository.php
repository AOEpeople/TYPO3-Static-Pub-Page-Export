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
 * @package staticpub_pageexport
 */
class Tx_StaticpubPageexport_Domain_Repository_FileRepository {
	/**
	 * @var array
	 */
	private $files = array();
	/**
	 * define the pageId, to which the files belong
	 * 
	 * @var integer
	 */
	private $pageId;

	/**
	 * @param Tx_StaticpubPageexport_Domain_Model_File $file
	 */
	public function addFile(Tx_StaticpubPageexport_Domain_Model_File $file) {
		$this->files[] = $file;
	}
	/**
	 * @return array
	 */
	public function getFiles() {
		return $this->files;
	}
	/**
	 * @return integer
	 */
	public function getPageId() {
		return $this->pageId;
	}

	/**
	 * @return boolean
	 */
	public function hasFiles() {
		return (count($this->files) > 0);
	}
	/**
	 * @param integer $pageId
	 */
	public function setPageId($pageId) {
		$this->pageId = $pageId;
	}
}