<?php

namespace App\Converter;

final class Wkhtmltopdf
{

    private $binaryPath;
    private $binaryName;
    private $params;
    private $inputFile;
    private $outputFile;
    private $footer;
    private $HtmlContent;

    public function __construct()
    {
        $this->binaryPath = '/usr/local/bin/';
        $this->binaryName = 'wkhtmltopdf ';
        $this->params = ' -qn --dpi 94 ';
    }

    public function setInputFile(string $file): self
    {
        $this->inputFile = $file;
        return $this;
    }

    public function setOutputFile(string $file): self
    {
        $this->outputFile = $file;
        return $this;
    }

    public function setFooter(string $html = null): self
    {
        $this->footer = (string) $html;
        return $this;
    }

    public function setParams($params): self
    {
        $this->params = $params;
        return $this;
    }

    public function setHtmlContent($html): self
    {
        $this->HtmlContent = $html;
        return $this;
    }

    private function genInputFile($html): string
    {
        // wkhtmltopdf DOES NOT WORK WITHOUT HTML file extension !!!!!
        $tmp_html_file = \tempnam('/tmp', \time()) . '.html';
        $ret = \file_put_contents($tmp_html_file, \str_replace('src="https', 'src="http', $html), LOCK_EX);
        \chmod($tmp_html_file, 0755);
        return $tmp_html_file;
    }

    public function exec(): string
    {
        if (empty($this->inputFile) && empty($this->HtmlContent)) {
            return '';
        }

        if (empty($this->inputFile) && !empty($this->HtmlContent)) {
            $this->inputFile = $this->genInputFile($this->HtmlContent);
        }
        $footerFile = $this->genInputFile($this->footer);
        $footer = empty($this->footer)
            ? ''
            : ' --margin-bottom 40mm --footer-html ' . $footerFile . ' ';

        $cmd = $this->binaryPath . $this->binaryName . ' ' . $this->params . ' ' .
            $footer . $this->inputFile . ' ' . $this->outputFile;

        $output = \exec($cmd);

        $this->cleanInputTmpFiles($this->inputFile);
        $this->cleanInputTmpFiles($footerFile);

        return $output;
    }

    private function cleanInputTmpFiles(?string $file): void
    {
        if (\file_exists($file)) {
            \unlink($file);
        }
        $simpleTmpFile = \str_replace('.html', '', $file);
        if (\file_exists($simpleTmpFile)) {
            \unlink($simpleTmpFile);
        }
    }

}
