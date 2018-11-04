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
     * @param ProjectRepository $projectRepository
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function list(ProjectRepository $projectRepository)
    {
        return $this->json(
            $projectRepository->transformAll()
        )->setStatusCode(200);
    }

    /**
     * @Route("/project/{id}/show", name="showProject")
     * @Method("GET")
     * @param int $id
     * @param ProjectRepository $projectRepository
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function show(int $id, ProjectRepository $projectRepository)
    {
        $project = $projectRepository->find($id);

        if (!$project) {
            return $this->json(["Object not found."])->setStatusCode(404);
        }

        return $this->json(
            $projectRepository->transform($project)
        )->setStatusCode(200);
    }


    /**
     * @Route("/project/add", name="addProject")
     * @Method("POST")
     * @param Request $request
     * @param ProjectRepository $projectRepository
     * @param EntityManagerInterface $em
     * @param JsonHelper $jsonHelper
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function add(Request $request, ProjectRepository $projectRepository, EntityManagerInterface $em, JsonHelper $jsonHelper)
    {
        try {
            $request = $jsonHelper->transformJsonBody($request, ['name', 'directory']);
            $name = $request['name'];
            $directory = $request['directory'];

            if (empty($name)) {
                throw new \Exception("Name cannot be empty");
            }

            if (empty($directory)) {
                throw new \Exception("Directory cannot be empty");
            }

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
     * @Route("/project/{id}/update", name="updateProject")
     * @Method("PUT")
     * @param int $id
     * @param Request $request
     * @param ProjectRepository $projectRepository
     * @param EntityManagerInterface $em
     * @param JsonHelper $jsonHelper
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function update(int $id, Request $request, ProjectRepository $projectRepository, EntityManagerInterface $em, JsonHelper $jsonHelper)
    {
        try {
            $request = $jsonHelper->transformJsonBody($request, ['name', 'directory']);
            $name = $request['name'];
            $directory = $request['directory'];

            if (empty($name)) {
                throw new \Exception("Name cannot be empty");
            }

            if (empty($directory)) {
                throw new \Exception("Directory cannot be empty");
            }

            $project = $projectRepository->find($id);

            if (!$project) {
                throw new \Exception("Could not find project with id: ".$id);
            }

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
     * @param int $id
     * @param Request $request
     * @param ProjectRepository $projectRepository
     * @param EntityManagerInterface $em
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function remove(int $id, Request $request, ProjectRepository $projectRepository, EntityManagerInterface $em)
    {
        try {
            $project = $projectRepository->find($id);

            if (!$project) {
                throw new \Exception("Could not find project with id: " . $id);
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
