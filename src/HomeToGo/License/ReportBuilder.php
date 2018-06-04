<?php

namespace HomeToGo\License;

use HomeToGo\License\Parser\ParserFactory;
use HomeToGo\License\Parser\UnknownFileFormatException;

class ReportBuilder
{

    /**
     * @param string $directory
     * @return Report
     */
    public function build($directory)
    {
        $report = new Report();
        $parserFactory = new ParserFactory();

        foreach (new \DirectoryIterator($directory) as $info) {
            try {
                $env = $parserFactory->parseFileName($info->getFilename(), ParserFactory::POS_ENV);
                foreach ($parserFactory->getParser($info->getFilename())->parse($info->getRealPath()) as $dependency) {
                    $dependency->setEnv($env);
                    $report->addDependency($dependency);
                }
            } catch (UnknownFileFormatException $ex) {
                // skip
            }
        }

        return $report;
    }
}
