<?php

namespace HomeToGo\License;

use HomeToGo\License\Normalizer\NormalizerInterface;
use HomeToGo\License\Parser\ParserFactory;
use HomeToGo\License\Parser\UnknownFileFormatException;

class ReportBuilder
{

    /**
     * @var null|NormalizerInterface
     */
    private $normalizer = null;

    /**
     * @param NormalizerInterface|null $normalizer
     * @return ReportBuilder
     */
    public function setNormalizer($normalizer)
    {
        $this->normalizer = $normalizer;
        return $this;
    }

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
                    $this->normalizer
                        && $dependency->setLicense($this->normalizer->normalize($dependency->getLicense()));
                    $report->addDependency($dependency);
                }
            } catch (UnknownFileFormatException $ex) {
                // skip
            }
        }

        return $report;
    }
}
