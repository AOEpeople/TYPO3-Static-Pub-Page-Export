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
 * test case for Tx_StaticpubPageexport_Domain_Repository_FileRepository
 * @package staticpub_pageexport
 * @subpackage Domain_Repository
 */
class Tx_StaticpubPageexport_Domain_Repository_FileRepositoryTest extends tx_phpunit_testcase
{
    /**
     * @var Tx_StaticpubPageexport_Domain_Repository_FileRepository
     */
    private $fileRepository;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        $this->fileRepository = t3lib_div::makeInstance('Tx_StaticpubPageexport_Domain_Repository_FileRepository');
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        unset($this->fileRepository);
    }

    /**
     * Test method addFile
     * @test
     */
    public function addFile()
    {
        $this->assertFalse($this->fileRepository->hasFiles());

        $file = new Tx_StaticpubPageexport_Domain_Model_File('name', 'originalPath', 'relativePath');
        $this->fileRepository->addFile($file);

        $this->assertTrue($this->fileRepository->hasFiles());
    }

    /**
     * Test method getFiles
     * @test
     */
    public function getFiles()
    {
        $newFile = new Tx_StaticpubPageexport_Domain_Model_File('name', 'originalPath', 'relativePath');
        $this->fileRepository->addFile($newFile);
        foreach ($this->fileRepository->getFiles() as $file) {
            $this->assertEquals($file, $newFile);
        }
    }

    /**
     * Test method getPageId
     * @test
     */
    public function getPageId()
    {
        $this->fileRepository->setPageId(1);
        $this->assertEquals(1, $this->fileRepository->getPageId());
    }

}
