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
 * test case for Tx_StaticpubPageexport_System_ZipArchive
 * @package staticpub_pageexport
 * @subpackage System
 */
class Tx_StaticpubPageexport_System_ZipArchiveTest extends tx_phpunit_testcase
{
    /**
     * @var Tx_StaticpubPageexport_Domain_Repository_FileRepository
     */
    private $fileRepository;
    /**
     * @var Tx_StaticpubPageexport_System_ZipArchive
     */
    private $zipArchive;
    /**
     * @var ZipArchive
     */
    private $zip;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        $this->fileRepository = $this->getMock('Tx_StaticpubPageexport_Domain_Repository_FileRepository', array(), array(), '', FALSE);
        $this->zip = $this->getMock('ZipArchive', array(), array(), '', FALSE);
        $this->zipArchive = $this->getMock('Tx_StaticpubPageexport_System_ZipArchive', array('createZipArchive', 'deleteFile', 'getFileContent', 'isReadable'));
        $this->zipArchive->expects($this->any())->method('createZipArchive')->will($this->returnValue($this->zip));
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        unset($this->fileRepository);
        unset($this->zipArchive);
        unset($this->zip);
    }

    /**
     * Test method getZipFileContent
     * @test
     */
    public function getZipFileContent_returnZipFileContent()
    {
        $zipFileContent = 'zip-file-content';

        // define behavior of zipArchive
        $this->zipArchive->expects($this->once())->method('isReadable')->will($this->returnValue(TRUE));
        $this->zipArchive->expects($this->once())->method('getFileContent')->will($this->returnValue($zipFileContent));
        $this->zipArchive->expects($this->once())->method('deleteFile');

        // define behavior of file and fileRepository
        $file = $this->getMock('Tx_StaticpubPageexport_Domain_Model_File', array(), array(), '', FALSE);
        $file->expects($this->once())->method('getOriginalPath')->will($this->returnValue('/original_path/'));
        $file->expects($this->once())->method('getRelativePath')->will($this->returnValue('relative_path/'));
        $file->expects($this->exactly(2))->method('getName')->will($this->returnValue('index.html'));
        $this->fileRepository->expects($this->once())->method('getFiles')->will($this->returnValue(array($file)));

        // define behavior of zip
        $this->zip->expects($this->once())->method('open')->will($this->returnValue(TRUE));
        $this->zip->expects($this->once())->method('addFile')->with('/original_path/index.html', 'relative_path/index.html')->will($this->returnValue(TRUE));
        $this->zip->expects($this->once())->method('close')->will($this->returnValue(TRUE));

        // execute test
        $content = $this->zipArchive->getZipFileContent($this->fileRepository);
        $this->assertEquals($zipFileContent, $content);
    }

    /**
     * Test method getZipFileContent
     * @test
     * @expectedException Tx_StaticpubPageexport_System_ZipArchiveException
     */
    public function getZipFileContent_throwException()
    {
        $this->zip->expects($this->once())->method('open')->will($this->returnValue(FALSE));
        $this->zipArchive->getZipFileContent($this->fileRepository);
    }

}
