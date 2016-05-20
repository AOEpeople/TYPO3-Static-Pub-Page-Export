<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

define ( 'PATH_tx_staticpub_pageexport', \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath ( 'staticpub_pageexport' ) );

if (!defined('PATH_tslib')) {
	define('PATH_tslib', \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath('cms') . 'tslib/');
}
