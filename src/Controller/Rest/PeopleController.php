<?php

namespace App\Controller\Rest;

use App\Entity\People;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\View;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\PeopleRepository;

class PeopleController extends FOSRestController
{
    /**
     * Creates an People resource
     * @Rest\Post("/people")
     * @param Request $request
     * @return Response
     */
    public function postPeople(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $people = new People();
        $people->setName($request->get('name'));
        $people->setCellphone($request->get('cellphone'));
        $people->setPhone($request->get('phone'));

        $em->persist($people);
        $em->flush();

        return new View\View($people, Response::HTTP_CREATED);
    }

    /**
     * Retrieves an People resource
     * @Rest\Get("/people/{peopleId}")
     */
    public function getPeople(int $peopleId)
    {
        $people = $this->getDoctrine()->getRepository(People::class)->find($peopleId);

        return new View\View($people, Response::HTTP_OK);
    }

    /**
     * Replaces People resource
     * @Rest\Put("/people/{peopleId}")
     */
    public function putPeople(int $peopleId, Request $request)
    {
        /** @var \App\Entity\People $people */
        $people = $this->getDoctrine()->getRepository(People::class)->find($peopleId);

        if($people){
            $em = $this->getDoctrine()->getManager();

            $people->setName($request->get('name'));
            $people->setCellphone($request->get('cellphone'));
            $people->setPhone($request->get('phone'));

            $em->persist($people);
            $em->flush();
        }

        return new View\View($people, Response::HTTP_OK);
    }

    /**
     * Removes the People resource
     * @Rest\Delete("/people/{peopleId}")
     */
    public function deletePeople(int $peopleId)
    {
        $em = $this->getDoctrine()->getManager();

        $people = $em->getRepository(People::class)->find($peopleId);

        if($people){
            $em->remove($people);
            $em->flush();
        }

        return new View\View([], Response::HTTP_NO_CONTENT);
    }
}