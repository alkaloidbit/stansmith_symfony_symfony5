<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

use App\Service\MediaManager;
use Symfony\Component\Finder\SplFileInfo;

class UpdateDbCommand extends Command
{
    protected static $defaultName = 'app:update-db';


    private $mediaManager;

    private $io;

    private $success = 0;
    private $ignored = 0;
    private $invalid = 0;

    public function __construct(MediaManager $mediaManager)
    {
        $this->mediaManager = $mediaManager;
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setDescription('Discover Files in configured directory and update Db')
            // configure an argument
            ->addArgument('pathContains', InputArgument::OPTIONAL, 'Path contains')
            ->addOption('dryrun', null, InputOption::VALUE_NONE, 'The command will do nothing but print info')
            ->addOption('show_table', null, InputOption::VALUE_NONE, 'The command will print a table showing results')
            ->addOption('dir', null, InputOption::VALUE_REQUIRED, 'Set path to the directory')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->io = new SymfonyStyle($input, $output);

        $this->io->title('Update DB');

        $pathContains = $input->getArgument('pathContains');
        if ($pathContains) {
            $this->io->note(sprintf('Processing files containing "%s" in their path...', $pathContains));
            $this->mediaManager->setPathOption($pathContains);
        }

        $dryrun = $input->getOption('dryrun');
        $show_table = $input->getOption('show_table');

        $results = $this->mediaManager->synchronize($input->getOption('dir'), $this, $dryrun);
        
        // results
        if ($show_table && !$dryrun) {
            $this->buildTable($output, $results);
        }

        $output->writeln([
            '',
        ]);

        $this->io->warning('You have '.$this->invalid.' invalid file(s)');
        $this->io->success('Completed! '.$this->success. ' new track(s), '.$this->ignored.' unchanged track(s)');

        return Command::SUCCESS;
    }


    public function buildTable($output, $data)
    {
        $table = new Table($output);
        $table
            ->setHeaders(['Filename', 'Status']);

        $rows = [];
        foreach ($data as $status => $subdata) {
            foreach ($subdata as $file) {
                $rows[] = [$file, $status];
            }
            $table->setRows($rows);
        }


        $table->render();
    }

    public function statsSynchronizationResult($result)
    {
        if ($result === 1) {
            $this->ignored++;
        } elseif ($result === 2) {
            $this->success++;
        } else {
            $this->invalid++;
        }
    }

    public function initProgress($count)
    {
        $this->io->progressStart($count);
    }

    public function advanceProgress()
    {
        $this->io->progressAdvance();
    }
     
    public function finishProgress()
    {
        $this->io->progressFinish();
    }
}
