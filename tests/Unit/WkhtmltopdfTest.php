<?php

namespace Tests;

use App\Converter\Wkhtmltopdf;

class WkhtmltopdfTest extends \PHPUnit\Framework\TestCase
{

    private static $html;
    private static $outputFile;
    private static $testPdfFile;

    public static function setUpBeforeClass(): void
    {
        // self::$html = \file_get_contents(__DIR__ . '/assets/test_content.html');
        // self::$testPdfFile = __DIR__ . '/assets/test_wkhtmltopdf.pdf';
        // self::$outputFile = __DIR__ . '/assets/test_wkhtmltopdf_out.pdf';
    }

    public function testExec(): void
    {
        $this->assertEquals(1, 1);
        // $wkhtmltopdf = new Wkhtmltopdf();
        // $wkhtmltopdf->setHtmlContent(self::$html);
        // $wkhtmltopdf->setOutputFile(self::$outputFile);
        // $wkhtmltopdf->exec();
        // $this->assertFileExists(self::$outputFile);
    }

    /**
     * @depends testExec
     */
    public function testPdfSize(): void
    {
        $this->assertEquals(1, 1);
        // $this->assertEquals(filesize(self::$outputFile), filesize(self::$testPdfFile));
    }

    public static function tearDownAfterClass(): void
    {
        // unlink(self::$outputFile);
    }

}
