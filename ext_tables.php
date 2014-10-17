<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

// register BE-module (show function to export newsletters)
if (TYPO3_MODE == 'BE') {
	t3lib_extMgm::insertModuleFunction(
		'web_func',
		'Tx_StaticpubPageexport_Controller_PageExportController',
		PATH_tx_staticpub_pageexport.'Classes/Controller/PageExportController.php',
		'LLL:EXT:staticpub_pageexport/locallang_db.xml:moduleFunction.tx_staticpub_pageexport_controller_pageExport'
	);
}
