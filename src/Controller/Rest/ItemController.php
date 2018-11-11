<?php

namespace App\Controller\Rest;

use App\Entity\Item;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\View;
use Symfony\Component\HttpFoundation\Request;

class ItemController extends FOSRestController
{
    /**
     * Creates an Item resource
     * @Rest\Post("/item")
     * @param Request $request
     * @return Response
     */
    public function postItem(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $item = new Item();
        $item->setName($request->get('name'));
        $item->setPrice($request->get('price'));
        $item->setNote($request->get('note'));

        $em->persist($item);
        $em->flush();

        return new View\View($item, Response::HTTP_CREATED);
    }

    /**
     * Retrieves an People resource
     * @Rest\Get("/item/{itemId}")
     */
    public function getItem(int $itemId)
    {
        $item = $this->getDoctrine()->getRepository(Item::class)->find($itemId);

        return new View\View($item, Response::HTTP_OK);
    }

    /**
     * Replaces People resource
     * @Rest\Put("/item/{itemId}")
     */
    public function putItem(int $itemId, Request $request)
    {
        /** @var \App\Entity\Item $item */
        $item = $this->getDoctrine()->getRepository(Item::class)->find($itemId);

        if($item){
            $em = $this->getDoctrine()->getManager();

            $item->setName($request->get('name'));
            $item->setPrice($request->get('price'));
            $item->setNote($request->get('note'));

            $em->persist($item);
            $em->flush();
        }

        return new View\View($item, Response::HTTP_OK);
    }

    /**
     * Removes the People resource
     * @Rest\Delete("/item/{itemId}")
     */
    public function deleteItem(int $itemId)
    {
        $em = $this->getDoctrine()->getManager();

        $item = $em->getRepository(Item::class)->find($itemId);

        if($item){
            $em->remove($item);
            $em->flush();
        }

        return new View\View([], Response::HTTP_NO_CONTENT);
    }
}