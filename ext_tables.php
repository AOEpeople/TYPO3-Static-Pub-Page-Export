<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

// register BE-module (show function to export newsletters)
if (TYPO3_MODE == 'BE') {
	\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::insertModuleFunction(
		'web_func',
		'Tx_StaticpubPageexport_Controller_PageExportController',
		NULL,
		'LLL:EXT:staticpub_pageexport/locallang_db.xml:moduleFunction.tx_staticpub_pageexport_controller_pageExport'
	);
}
