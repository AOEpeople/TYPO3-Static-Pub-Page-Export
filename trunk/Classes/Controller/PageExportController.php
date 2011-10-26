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

require_once(PATH_t3lib.'class.t3lib_extobjbase.php');

/**
 * Controller for Cache Management
 * @package staticpub_pageexport
 */
class Tx_StaticpubPageexport_Controller_PageExportController extends t3lib_extobjbase {
	/**
	 * MAIN function for static publishing information
	 *
	 * @return	string		Output HTML for the module.
	 */
	function main()	{
		$content = '';

		// show button
		$nameStartExport = $GLOBALS['LANG']->sL('LLL:EXT:staticpub_pageexport/locallang_db.xml:moduleFunction.tx_staticpub_pageexport_controller_pageExport.startExport',1);
		$content .= $this->renderActionButton('startExport', $nameStartExport);

		// Handle actions
		$this->handleActions( $content );

		return $content;
	}

	/**
	 * @return Tx_StaticpubPageexport_System_PageExport
	 */
	protected function getPageExport() {
		return t3lib_div::makeInstance('Tx_StaticpubPageexport_System_PageExport');
	}
	/**
	 * @return Tx_StaticpubPageexport_System_ZipArchive
	 */
	protected function getZipArchive() {
		return t3lib_div::makeInstance('Tx_StaticpubPageexport_System_ZipArchive');
	}
	/**
	 * Handles incoming actions (e.g. removing all expired pages).
	 *
	 * @param &$content
	 * @return	void
	 */
	protected function handleActions(&$content) {
		$action = t3lib_div::_GP('ACTION');
		if (isset($action['startExport'])) {
			try {
				$pageId = (integer) t3lib_div::_GP('id');
				$fileRepository = $this->getPageExport()->exportPage( $pageId );

				if($fileRepository->hasFiles() === TRUE) {
					$this->sendZipArchive( $fileRepository );
				} else {
					$errorMessage = $GLOBALS['LANG']->sL('LLL:EXT:staticpub_pageexport/locallang_db.xml:moduleFunction.tx_staticpub_pageexport_controller_pageExport.errorFileRepositoryHasNoFiles',1);
					$content .= '<br /><br />'.$errorMessage;
				}
			} catch (Tx_StaticpubPageexport_System_ZipArchiveException $e) {
				$content .= '<br /><br />'.$e->getMessage();
			} catch (Exception $e) {
					$errorMessage = $GLOBALS['LANG']->sL('LLL:EXT:staticpub_pageexport/locallang_db.xml:moduleFunction.tx_staticpub_pageexport_controller_pageExport.errorIsUnknown',1);
					$content .= '<br /><br />'.$errorMessage;
			}
		}
	}
	/**
	 * Renders a single action button,
	 *
	 * @param	string		$elementName: Name attribute of the element
	 * @param	string		$elementLabel: Label of the action button
	 * @param	string		$confirmationText: (optional) Confirmation text - will not be used if empty
	 * @return	string		The HTML representation of an action button
	 */
	protected function renderActionButton($elementName, $elementLabel, $confirmationText = '') {
		return '<input type="submit" name="ACTION[' . htmlspecialchars($elementName) . ']" value="' . $elementLabel . '"' .
			($confirmationText ? ' onclick="return confirm(\'' . addslashes($confirmationText) . '\');"' : '') . ' />';
	}
	/**
	 * @param $fileRepository
	 */
	protected function sendZipArchive(Tx_StaticpubPageexport_Domain_Repository_FileRepository $fileRepository) {
		$zipFileContent = $this->getZipArchive()->getZipFileContent( $fileRepository );

		// set header
		header('Content-Type: "application/x-gzip"');
		header('Expires: '.gmdate('D, d M Y H:i:s').' GMT');
		header('Content-Disposition: inline; filename="page_'.$fileRepository->getPageId().'.zip"');
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Pragma: public');

		// set file
		echo $zipFileContent;
		exit();
	}
}