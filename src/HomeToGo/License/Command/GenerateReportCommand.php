<?php

namespace HomeToGo\License\Command;

use HomeToGo\License\Output\TableOutput;
use HomeToGo\License\ReportBuilder;
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
        $this->getOutput($input, $output)->output(
            (new ReportBuilder())->build($input->getArgument('dir'))
        );

        $output->writeln('Done');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return \HomeToGo\License\Output\OutputInterface
     */
    protected function getOutput(InputInterface $input, OutputInterface $output)
    {
        return (new TableOutput($output));
    }
}
