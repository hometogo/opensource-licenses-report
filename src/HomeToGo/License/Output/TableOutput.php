<?php

namespace HomeToGo\License\Output;

use HomeToGo\License\Report;
use Symfony\Component\Console\Helper\Table;

class TableOutput implements OutputInterface
{

    /**
     * @var \Symfony\Component\Console\Output\OutputInterface
     */
    private $output;

    /**
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     */
    public function __construct(\Symfony\Component\Console\Output\OutputInterface $output)
    {
        $this->output = $output;
    }

    /**
     * @param Report $report
     */
    public function output(Report $report)
    {
        $table = new Table($this->output);
        $table->setHeaders($report->getHeader());
        $table->setRows($report->getBody());
        $table->render();
    }
}
