<?php

namespace HomeToGo\License\Output;

use HomeToGo\License\Report;

class CsvOutput implements OutputInterface
{

    /** @var string */
    private $outfile;

    /**
     * @param string $outfile
     */
    public function __construct($outfile)
    {
        $this->outfile = $outfile;
    }

    /**
     * @param Report $report
     */
    public function output(Report $report)
    {
        $handle = fopen($this->outfile, 'w');

        fputcsv($handle, $report->getHeader());
        foreach ($report->getBody() as $row) {
            fputcsv($handle, $row);
        }
    }
}
