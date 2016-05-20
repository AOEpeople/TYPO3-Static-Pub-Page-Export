<?php
$extensionPath = \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath('staticpub_pageexport');
return array(
    'tx_staticpubpageexport_controller_pageexportcontroller' => $extensionPath . 'Classes/Controller/PageExportController.php',
    'tx_staticpubpageexport_domain_model_file' => $extensionPath . 'Classes/Domain/Model/File.php',
    'tx_staticpubpageexport_domain_repository_filerepository' => $extensionPath . 'Classes/Domain/Repository/FileRepository.php',
    'tx_staticpubpageexport_system_pageexport' => $extensionPath . 'Classes/System/PageExport.php',
    'tx_staticpubpageexport_system_ziparchive' => $extensionPath . 'Classes/System/ZipArchive.php',
    'tx_staticpubpageexport_system_ziparchiveexception' => $extensionPath . 'Classes/System/ZipArchiveException.php',
);
