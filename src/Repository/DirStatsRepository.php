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
}
