<?php

namespace App\Repository;

use App\Entity\Project;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Project|null find($id, $lockMode = null, $lockVersion = null)
 * @method Project|null findOneBy(array $criteria, array $orderBy = null)
 * @method Project[]    findAll()
 * @method Project[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProjectRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Project::class);
    }

    public function transform(Project $project)
    {
        return [
            'id' => (int)$project->getId(),
            'name' => (string)$project->getName(),
            'directory' => (string)$project->getDirectory(),
            'created_at' => (string) $project->getCreatedAt()->format("Y-m-d H:i:s")
        ];
    }

    public function transformAll()
    {
        $projects = $this->findAll();

        foreach ($projects as &$project) {
            $project = $this->transform($project);
        }

        return $projects;
    }

}
