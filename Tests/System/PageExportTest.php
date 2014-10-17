<?php
/***************************************************************
 * Copyright notice
 *
 * (c) 2014 AOE GmbH <dev@aoe.com>
 * All rights reserved
 *
 *
 * This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

/**
 * test case for Tx_StaticpubPageexport_System_PageExport
 * @package staticpub_pageexport
 * @subpackage System
 */
class Tx_StaticpubPageexport_System_PageExportTest extends tx_phpunit_testcase
{
    /**
     * @var tx_crawler_lib
     */
    private $crawlerObj;
    /**
     * @var array
     */
    private $expectedFiles = array();
    /**
     * @var Tx_StaticpubPageexport_Domain_Repository_FileRepository
     */
    private $fileRepository;
    /**
     * @var Tx_StaticpubPageexport_System_PageExport
     */
    private $pageExport;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        $this->crawlerObj = $this->getMock('tx_crawler_lib', array(), array(), '', FALSE);
        $this->fileRepository = $this->getMock('Tx_StaticpubPageexport_Domain_Repository_FileRepository', array(), array(), '', FALSE);

        $this->pageExport = $this->getMock('Tx_StaticpubPageexport_System_PageExport', array('createFile', 'getCrawler', 'getFileRepository', 'getPathSite'));
        $this->pageExport->expects($this->any())->method('createFile')->will($this->returnCallback(array($this, 'CallbackFunctionCreateFile')));
        $this->pageExport->expects($this->any())->method('getCrawler')->will($this->returnValue($this->crawlerObj));
        $this->pageExport->expects($this->any())->method('getFileRepository')->will($this->returnValue($this->fileRepository));
        $this->pageExport->expects($this->any())->method('getPathSite')->will($this->returnValue($this->getPathSite()));
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        unset($this->crawlerObj);
        unset($this->fileRepository);
        unset($this->pageExport);
    }

    /**
     * Local callback used to check, if files will be created with correct values
     *
     * @param string $name
     * @param string $originalPath
     * @param string $relativePath
     * @return Tx_StaticpubPageexport_Domain_Model_File
     */
    public function CallbackFunctionCreateFile($name, $originalPath, $relativePath)
    {
        $parametersAreValid = FALSE;
        foreach ($this->expectedFiles as $expectedFile) {
            if ($expectedFile['name'] === $name && $expectedFile['originalPath'] === $originalPath && $expectedFile['relativePath'] === $relativePath) {
                $parametersAreValid = TRUE;
                break;
            }
        }
        $this->assertTrue($parametersAreValid);
        return new Tx_StaticpubPageexport_Domain_Model_File($name, $originalPath, $relativePath);
    }

    /**
     * Test method exportPage
     * @test
     */
    public function exportPage()
    {
        // define data of mocked logEntry
        $pageId = 111;
        $publishDir = 'typo3temp/staticpub/';
        $publishDirForResources = 'typo3temp/staticpub_resources/';
        $staticpubPath = 'page_111/';

        $file1 = array();
        $file1['name'] = 'index.html';
        $file1['relativePath'] = '';
        $file1['originalPath'] = $this->getPathSite() . $publishDir . $staticpubPath . $file1['relativePath'];
        // result will be: /srv/www/congstar/phpuc/htdocs/typo3temp/staticpub/page_111/
        $file2 = array();
        $file2['name'] = 'test.jpg';
        $file2['relativePath'] = 'images/';
        $file2['originalPath'] = $this->getPathSite() . $publishDirForResources . $file2['relativePath'];
        // result will be:/srv/www/congstar/phpuc/htdocs/typo3temp/staticpub_resources/images/
        $this->expectedFiles = array($file1, $file2);

        $imageConfig = array();
        $imageConfig['filename'] = 'test.jpg';
        $imageConfig['path'] = 'images/';

        $contentData = array();
        $contentData['success']['tx_staticpub'] = TRUE;
        $contentData['log'] = array();
        $contentData['log']['tx_staticpub_publishdir'] = $publishDir;
        $contentData['log']['tx_staticpub_path'] = $staticpubPath;
        $contentData['log']['resources'] = array();
        $contentData['log']['resources']['jpg'] = array($imageConfig);
        $contentData['parameters']['procInstrParams']['tx_staticpub_publish.']['publishDirForResources'] = $publishDirForResources;

        $resultData = array();
        $resultData['content'] = serialize($contentData);

        $logEntry = array();
        $logEntry['page_id'] = $pageId;
        $logEntry['result_data'] = serialize($resultData);

        // define behavior of mocked objects
        $this->crawlerObj->expects($this->once())->method('getPageTreeAndUrls');
        $this->crawlerObj->expects($this->once())->method('CLI_main');
        $this->crawlerObj->expects($this->once())->method('getLogEntriesForSetId')->will($this->returnValue(array($logEntry)));
        $this->fileRepository->expects($this->at(0))->method('addFile');
        $this->fileRepository->expects($this->at(1))->method('addFile');
        $this->fileRepository->expects($this->at(2))->method('setPageId')->with($pageId);

        // execute test
        $fileRepository = $this->pageExport->exportPage($pageId);
        $this->assertEquals($this->fileRepository, $fileRepository);
    }

    /**
     * @return string
     */
    private function getPathSite()
    {
        return '/srv/www/congstar/phpuc/htdocs/';
    }

}
