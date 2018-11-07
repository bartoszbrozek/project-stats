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
     * @Route("/dirstats/{id}/show", name="showProject")
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
}
