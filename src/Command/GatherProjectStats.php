<?php

namespace App\Command;

use App\Service\ProjectManager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GatherProjectStats extends Command
{
    private $projectManager;

    public function __construct(ProjectManager $projectManager)
    {
        $this->projectManager = $projectManager;

        parent::__construct();
    }

    /**
     * Configure command
     */
    protected function configure()
    {
        $this
            ->setName("app:gatherprojectstats")
            ->setDescription("Gathers projects information and saves it");
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|null|void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln("Starting GatherProjectStats!");

        // Get dirs to scan
        $dirs = $this->projectManager->getDirs();

        // Scan dirs
        foreach ($dirs as $dir) {
            try {
                $output->writeln("<fg=black;bg=green;>Gathering data of {$dir->getDirectory()} directory</>");
                $this->projectManager->startGatheringData($dir->getDirectory(), $dir->getId());
            } catch (\Exception $ex) {
                $output->writeln("<fg=white;bg=red;>Error: {$ex->getMessage()}</>");
            }
        }

        $output->writeln("Finished! Scanned: ".count($this->projectManager->getScannedFiles())." files");

        foreach ($this->projectManager->getErrors() as $error) {
            $output->writeln("<fg=white;bg=red;>File Error: {$error['file']}: {$error['msg']}</>");
        }
    }
}