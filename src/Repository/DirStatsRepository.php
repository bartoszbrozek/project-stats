<?php

namespace App\Repository;

use App\Entity\DirStats;
use App\Entity\Project;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method DirStats|null find($id, $lockMode = null, $lockVersion = null)
 * @method DirStats|null findOneBy(array $criteria, array $orderBy = null)
 * @method DirStats[]    findAll()
 * @method DirStats[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DirStatsRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, DirStats::class);
    }

    public function transform(DirStats $dirStats)
    {
        return [
            'id' => (int)$dirStats->getId(),
            'scanid' => $dirStats->setScanid()
        ];
    }

    public function findByProjectId(int $projectid)
    {
        return $this->createQueryBuilder('d')
            ->select("d.id, d.relativeDirectory, d.filename, d.filesize, d.numberOfLines, d.created_at")
            ->where("d.projectid = :projectid")
            ->setParameter("projectid", $projectid)
            ->getQuery()->execute();
    }

    public function findScanIdsByProjectId(int $projectid)
    {
        return $this->createQueryBuilder('d')
            ->select("d.scanid, d.created_at")
            ->where("d.projectid = :projectid")
            ->groupBy("d.scanid")
            ->orderBy("d.id", "desc")
            ->setParameter("projectid", $projectid)
            ->getQuery()->execute();
    }

    public function findByProjectIdAndScanId(int $projectid, string $scanid)
    {
        return $this->createQueryBuilder('d')
            ->select("d.id, d.relativeDirectory, d.filename, d.filesize, d.numberOfLines, d.created_at")
            ->where("d.projectid = :projectid")
            ->andWhere("d.scanid = :scanid")
            ->orderBy("d.id", "asc")
            ->setParameter("projectid", $projectid)
            ->setParameter("scanid", $scanid)
            ->getQuery()->execute();
    }
}
