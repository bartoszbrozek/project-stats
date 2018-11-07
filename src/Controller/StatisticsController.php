<?php

namespace App\Controller;

use App\Entity\Project;
use App\Repository\DirStatsRepository;
use App\Repository\ProjectRepository;
use App\Service\JsonHelper;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class StatisticsController extends AbstractController
{
    /**
     * @Route("/dirstats/{id}/show", name="showDirStats")
     * @Method("GET")
     * @param int $id
     * @param DirStatsRepository $dirStatsRepository
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function show(int $id, DirStatsRepository $dirStatsRepository)
    {
        $dirStats = $dirStatsRepository->findByProjectId($id);

        if (!$dirStats) {
            return $this->json(["Object not found."])->setStatusCode(404);
        }

        return $this->json(
            $dirStats
        )->setStatusCode(200);
    }

    /**
     * @Route("/dirstats/{id}/show/{scanid}", name="showDirStatsByScanId")
     * @Method("GET")
     * @param int $id
     * @param DirStatsRepository $dirStatsRepository
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function showByScanId(int $id, string $scanid, DirStatsRepository $dirStatsRepository)
    {
        $dirStats = $dirStatsRepository->findByProjectIdAndScanId($id, $scanid);

        if (!$dirStats) {
            return $this->json(["Object not found."])->setStatusCode(404);
        }

        return $this->json(
            $dirStats
        )->setStatusCode(200);
    }

    /**
     * @Route("/dirstats/scanid/{projectid}/get", name="getScanIdsByProjectId")
     * @Method("GET")
     * @param int $projectid
     * @param DirStatsRepository $dirStatsRepository
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function getScanIds(int $projectid, DirStatsRepository $dirStatsRepository)
    {
        $scanIds = $dirStatsRepository->findScanIdsByProjectId($projectid);

        if (!$scanIds) {
            return $this->json(["Object not found."])->setStatusCode(404);
        }

        return $this->json(
            $scanIds
        )->setStatusCode(200);
    }
}
