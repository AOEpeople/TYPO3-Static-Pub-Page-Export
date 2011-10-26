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

require_once(PATH_tx_staticpub_pageexport . 'Classes/System/ZipArchiveException.php');

/**
 * This class creates a zip-archive on base of the file-repository
 * 
 * @package staticpub_pageexport
 */
class Tx_StaticpubPageexport_System_ZipArchive {
	/**
	 * @param Tx_StaticpubPageexport_Domain_Repository_FileRepository $fileRepository
	 * @return string
	 */
	public function getZipFileContent(Tx_StaticpubPageexport_Domain_Repository_FileRepository $fileRepository) {
		$zipFile = PATH_site.'typo3temp/'.t3lib_div::md5int(microtime()).'.zip';
		$zipArchive = $this->createZipArchive();

		$this->createZipFile($zipArchive, $zipFile);
		$this->addFilesToZipFile($zipArchive, $fileRepository);
		$this->closeZipFile($zipArchive);

		$content = $this->getFileContent( $zipFile );
		$this->deleteFile($zipFile);

		return $content;
	}

	/**
	 * @return ZipArchive
	 */
	protected function createZipArchive() {
		return new ZipArchive();
	}
	/**
	 * @param string $filename
	 */
	protected function deleteFile($filename) {
		unlink($filename);
	}
	/**
	 * @param string $filename
	 * @return string
	 */
	protected function getFileContent($filename) {
		return file_get_contents( $filename );
	}
	/**
	 * @param string $filename
	 * @return boolean
	 */
	protected function isReadable($filename) {
		return is_readable($filename);
	}
	/**
	 * @param string $message
	 * @throw Tx_StaticpubPageexport_System_ZipArchiveException
	 */
	protected function throwException($message) {
		throw new Tx_StaticpubPageexport_System_ZipArchiveException($message);
	}

	/**
	 * @param ZipArchive $zipArchive
	 * @param Tx_StaticpubPageexport_Domain_Repository_FileRepository $fileRepository
	 */
	private function addFilesToZipFile(ZipArchive $zipArchive, Tx_StaticpubPageexport_Domain_Repository_FileRepository $fileRepository) {
		/* @var $file Tx_StaticpubPageexport_Domain_Model_File */
		foreach($fileRepository->getFiles() as $file) {
			$filename = $file->getOriginalPath() . $file->getName();
			$localName = $file->getRelativePath() . $file->getName();
			if($this->isReadable($filename)) {
				if($zipArchive->addFile($filename, $localName) === FALSE) {
					$this->throwException( 'can not add file "'.$localName.'" to archive' );
				}
			}
		}
	}
	/**
	 * @param ZipArchive $zipArchive
	 */
	private function closeZipFile(ZipArchive $zipArchive) {
		if($zipArchive->close() === FALSE) {
			$this->throwException( 'can not close archive' );
		}
	}
	/**
	 * @param ZipArchive $zipArchive
	 * @param string $zipFile
	 */
	private function createZipFile(ZipArchive $zipArchive, $zipFile) {
		if($zipArchive->open( $zipFile, ZIPARCHIVE::CREATE ) === FALSE) {
			$this->throwException( 'can not create new archive "'.$zipFile.'"' );
		}
	}
}