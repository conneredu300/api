<?php

namespace App\Controller\Rest;

use App\Entity\ShipOrder;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\View;
use Symfony\Component\HttpFoundation\Request;

class ShipOrderController extends FOSRestController
{
    /**
     * Creates an ShipOrder resource
     * @Rest\Post("/shiporder")
     * @param Request $request
     * @return Response
     */
    public function postShipOrder(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $shipOrder = new ShipOrder();
        $shipOrder->setAddress($request->get('address'));
        $shipOrder->setPeople($request->get('peopleId'));
        $shipOrder->setItem($request->get('itemId'));

        $em->persist($shipOrder);
        $em->flush();

        return new View\View($shipOrder, Response::HTTP_CREATED);
    }

    /**
     * Retrieves an ShipOrder resource
     * @Rest\Get("/shiporder/{shipOrderId}")
     */
    public function getShipOrder(int $shipOrderId)
    {
        $shipOrder = $this->getDoctrine()->getRepository(ShipOrder::class)->find($shipOrderId);

        return new View\View($shipOrder, Response::HTTP_OK);
    }

    /**
     * Replaces ShipOrder resource
     * @Rest\Put("/shiporder/{shipOrderId}")
     */
    public function putShipOrder(int $shipOrderId, Request $request)
    {
        /** @var \App\Entity\ShipOrder $shipOrder */
        $shipOrder = $this->getDoctrine()->getRepository(ShipOrder::class)->find($shipOrderId);

        if($shipOrder){
            $em = $this->getDoctrine()->getManager();

            $shipOrder->setAddress($request->get('address'));
            $shipOrder->setPeople($request->get('peopleId'));
            $shipOrder->setItem($request->get('itemId'));

            $em->persist($shipOrder);
            $em->flush();
        }

        return new View\View($shipOrder, Response::HTTP_OK);
    }

    /**
     * Removes the ShipOrder resource
     * @Rest\Delete("/shiporder/{shipOrderId}")
     */
    public function deleteShipOrder(int $shipOrderId)
    {
        $em = $this->getDoctrine()->getManager();

        $shipOrder = $em->getRepository(Item::class)->find($shipOrderId);

        if($shipOrder){
            $em->remove($shipOrder);
            $em->flush();
        }

        return new View\View([], Response::HTTP_NO_CONTENT);
    }
}