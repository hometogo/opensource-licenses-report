<?php

namespace HomeToGo\License\Output;

use HomeToGo\License\Report;

interface OutputInterface
{

    /**
     * @param Report $report
     */
    public function output(Report $report);
}
