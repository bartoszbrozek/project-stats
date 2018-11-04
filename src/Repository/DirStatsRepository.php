<?php

namespace App\Repository;

use App\Entity\DirStats;
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
}
