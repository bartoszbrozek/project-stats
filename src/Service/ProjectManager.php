<?php

namespace App\Service;

use App\Entity\DirStats;
use App\Repository\ProjectRepository;
use Doctrine\ORM\EntityManagerInterface;

class ProjectManager
{
    private $projectRepository;
    private $scanid;
    private $gatheredData = [];
    private $errors = [];
    private $scannedFiles = [];
    private $em;

    public function __construct(ProjectRepository $projectRepository, EntityManagerInterface $em)
    {
        $this->projectRepository = $projectRepository;
        $this->generateScanId();
        $this->em = $em;
    }

    /**
     * @return \App\Entity\Project[]
     */
    public function getDirs()
    {
        $dirs = $this->projectRepository->findAll();

        return $dirs;
    }

    /**
     * @param string $dir
     * @param int $projectid
     * @return array
     * @throws \Exception
     */
    public function startGatheringData(string $dir, int $projectid)
    {
        if (empty($dir)) {
            throw new \Exception("Dir cannot be empty");
        }

        // Check if $dir is a valid directory
        if (!is_dir($dir)) {
            throw  new \Exception("{$dir} is not a valid directory");
        }

        $actualDir = array_diff(scandir($dir), [".", ".."]);

        foreach ($actualDir as $name) {
            $fulldir = $dir . DIRECTORY_SEPARATOR . $name;
            echo "SCANNING NOW: " . $fulldir . PHP_EOL;
            if (is_dir($fulldir)) {
                $this->startGatheringData($fulldir, $projectid);
            } else {
                // This is probably a file
                $this->gatheredData[] = $name;

                if (is_readable($fulldir)) {
                    $status = "OK";

                    try {
                        $filesize = filesize($fulldir);
                    } catch (\Exception $ex) {
                        $filesize = 0;
                        $status = "FILESIZE_ERROR";
                    }

                    $numberOflines = $this->countLines($fulldir);
                    $this->saveFileDetails($projectid, $name, $dir, $filesize, $numberOflines, $status);
                    $this->scannedFiles[] = $fulldir;
                } else {
                    $this->setError("File is not readable or is not a file", $fulldir);
                }
            }
        }

        return $this->gatheredData;
    }

    /**
     * @return array
     */
    public function getGatheredData()
    {
        return $this->gatheredData;
    }

    /**
     * @return array
     */
    public function getScannedFiles()
    {
        return $this->scannedFiles;
    }

    /**
     * @return array
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * @param int $projectid
     * @param string $filename
     * @param string $dir
     * @param int $filesize
     * @param int $numberOfLines
     * @param string $status
     */
    public function saveFileDetails(int $projectid, string $filename, string $dir, int $filesize, int $numberOfLines, string $status = "OK")
    {
        $project = $this->projectRepository->find($projectid);

        $dirStats = new DirStats();
        $dirStats->setProjectid($project);
        $dirStats->setFilename($filename);
        $dirStats->setRelativeDirectory($dir);
        $dirStats->setFilesize($filesize);
        $dirStats->setNumberOfLines($numberOfLines);
        $dirStats->setStatus($status);
        $dirStats->setScanid($this->scanid);

        $this->em->persist($dirStats);
        $this->em->flush();
    }

    /**
     * Generates scan id
     */
    private function generateScanId()
    {
        $this->scanid = md5(microtime());
    }

    private function setError(string $msg, string $file)
    {
        $this->errors[] = [
            'msg' => $msg,
            'file' => $file
        ];
    }

    /**
     * @param string $file
     * @return int
     */
    private function countLines(string $file)
    {
        $numberOfLines = 0;
        $handle = fopen($file, "r");

        while (!feof($handle)) {
            fgets($handle);
            $numberOfLines++;
        }

        fclose($handle);

        return $numberOfLines;
    }
}