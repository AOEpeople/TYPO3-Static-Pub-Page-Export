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

		$content = file_get_contents( $zipFile );
		unlink($zipFile);

		return $content;
	}

	/**
	 * @return ZipArchive
	 */
	protected function createZipArchive() {
		return new ZipArchive();
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
			if(is_readable($filename)) {
				if($zipArchive->addFile($filename, $localName) === FALSE) {
					throw new LogicException('can not add file "'.$localName.'" to archive');
				}
			}
		}
	}
	/**
	 * @param ZipArchive $zipArchive
	 */
	private function closeZipFile(ZipArchive $zipArchive) {
		if($zipArchive->close() === FALSE) {
			throw new LogicException('can not close archive');
		}
	}
	/**
	 * @param ZipArchive $zipArchive
	 * @param string $zipFile
	 */
	private function createZipFile(ZipArchive $zipArchive, $zipFile) {
		if($zipArchive->open( $zipFile, ZIPARCHIVE::CREATE ) === FALSE) {
			throw new LogicException('can not create new archive "'.$zipFile.'"');
		}
	}
}