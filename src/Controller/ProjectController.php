<?php

namespace App\Controller;

use App\Entity\Project;
use App\Repository\ProjectRepository;
use App\Service\JsonHelper;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class ProjectController extends AbstractController
{
    /**
     * @Route("/project/list", name="listProjects")
     * @Method("GET")
     */
    public function list(ProjectRepository $projectRepository)
    {
        return $this->json(
            $projectRepository->transformAll()
        )->setStatusCode(200);
    }

    /**
     * @Route("/project/show/{$id}", name="showProject")
     * @Method("GET")
     */
    public function show(int $id, ProjectRepository $projectRepository)
    {
        $project = $this->json([
            $projectRepository->find($id)
        ])->setStatusCode(200);

        if (!$project) {
            return $this->json(["Object not found."])->setStatusCode(404);
        }

        return $this->json([
            $project
        ])->setStatusCode(200);
    }


    /**
     * @Route("/project/add", name="addProject")
     * @Method("POST")
     */
    public function add(Request $request, ProjectRepository $projectRepository, EntityManagerInterface $em, JsonHelper $jsonHelper)
    {
        try {
            $request = $jsonHelper->transformJsonBody($request, ['name', 'directory']);
            $name = $request['name'];
            $directory = $request['directory'];

            $project = new Project();
            $project->setName($name);
            $project->setDirectory($directory);
            $em->persist($project);
            $em->flush();

            return $this
                ->json(["msg" => "Object created", "object" => $projectRepository->transform($project)])
                ->setStatusCode(200);

        } catch (\Exception $ex) {
            return $this->json(["error" => $ex->getMessage()])->setStatusCode(400);
        }
    }


    /**
     * @Route("/project/{id}/remove", name="removeProject")
     * @Method("DELETE")
     */
    public function remove(int $id, Request $request, ProjectRepository $projectRepository, EntityManagerInterface $em, JsonHelper $jsonHelper)
    {
        try {
            $project = $projectRepository->find($id);

            if (!$project) {
                throw new \Exception("Could not find project with id: ".$id);
            }

            $em->remove($project);
            $em->flush();

            return $this
                ->json(["msg" => "Object removed", "id" => $id])
                ->setStatusCode(200);

        } catch (\Exception $ex) {
            return $this->json(["error" => $ex->getMessage()])->setStatusCode(400);
        }
    }


}
