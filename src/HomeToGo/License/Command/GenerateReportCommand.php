<?php

namespace HomeToGo\License\Command;

use HomeToGo\License\Normalizer\Composite;
use HomeToGo\License\Normalizer\Replacements;
use HomeToGo\License\Normalizer\SPDXNormalizer;
use HomeToGo\License\Output\CsvOutput;
use HomeToGo\License\Output\HtmlOutput;
use HomeToGo\License\Output\TableOutput;
use HomeToGo\License\Report;
use HomeToGo\License\ReportBuilder;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
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
            ->addArgument('dir', InputArgument::REQUIRED, 'Directory for dependency reports')
            ->addOption(
                'format',
                'f',
                InputOption::VALUE_REQUIRED,
                'Output format. Possible values: text, csv, html',
                'text'
            )->addOption(
                'output',
                'o',
                InputOption::VALUE_REQUIRED,
                'Output file name',
                'data/report.csv'
            )->addOption(
                'columns',
                'c',
                InputOption::VALUE_IS_ARRAY | InputOption::VALUE_REQUIRED,
                'List only specific columns',
                Report::DEFAULT_COLUMNS
            )->addOption(
                'project-columns',
                'p',
                InputOption::VALUE_NONE,
                'Show project columns'
            )->addOption(
                'unique-lines',
                'u',
                InputOption::VALUE_NONE,
                'Show unique lines'
            );
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->getOutput($input, $output)->output(
            (new ReportBuilder())
                ->setNormalizer(
                    (new Composite())
                        ->addNormaliser(new SPDXNormalizer())
                        ->addNormaliser(new Replacements())
                )
                ->build($input->getArgument('dir'))
                    ->setColumns($input->getOption('columns'))
                    ->setShowProjectColumns($input->getOption('project-columns') ? true : false)
                    ->setUnique($input->getOption('unique-lines') ? true : false)
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
        switch ($input->getOption('format')) {
            case 'text':
                return new TableOutput($output);
                break;
            case 'csv':
                return new CsvOutput($input->getOption('output'));
                break;
            case 'html':
                return new HtmlOutput($input->getOption('output'));
                break;
        }

        throw new \InvalidArgumentException('Supported formats csv, text, html');
    }
}
