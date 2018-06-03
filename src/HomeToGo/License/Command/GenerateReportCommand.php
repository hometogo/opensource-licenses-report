<?php

namespace HomeToGo\License\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GenerateReportCommand extends Command
{

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setName('generate-report')
            ->setDescription('Generates license report')
            ->addArgument('dir', InputArgument::REQUIRED, 'Directory for dependency reports');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('Placeholder');
    }
}
