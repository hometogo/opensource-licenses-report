<?php

namespace HomeToGo\License\Output;

use HomeToGo\License\Report;
use Twig_Environment;
use Twig_Loader_Filesystem;

class HtmlOutput implements OutputInterface
{
    /**
     * @var string
     */
    private $outputFile;

    /**
     * @param string $outputFile
     */
    public function __construct($outputFile)
    {
        $this->outputFile = $outputFile;
    }

    /**
     * @param Report $report
     */
    public function output(Report $report)
    {
        $loader = new Twig_Loader_Filesystem(dirname(__FILE__).DIRECTORY_SEPARATOR.'templates');
        $twig = new Twig_Environment($loader);

        file_put_contents(
            $this->outputFile,
            $twig->render('report.html.twig', ['report' => $report])
        );
    }
}
