<?php

namespace App\Controller;

use App\Entity\Item;
use App\Entity\ShipOrder;
use Doctrine\DBAL\DBALException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Form\FilesType;
use App\Entity\People;

class IndexController extends AbstractController
{
    /**
     * @Route("", name="index", methods={"GET","POST"})
     */
    public function index(Request $request)
    {
        $arrParams = [
            'form' => $this->createForm(FilesType::class)->createView(),
            'success' => false
        ];

        if ($request->isMethod('Post')) {

            $file = $_FILES["files"]["tmp_name"]["file"];
            $file = simplexml_load_file($file);

            $em = $this->getDoctrine()->getManager();

            if ($file->getName() == "people") {
                try {
                    foreach ($file as $item) {
                        $people = new People();
                        $people->setName($item->personname);
                        $people->setPhone($item->phones->phone[0]);

                        if ($item->phones->phone[1]) {
                            $people->setCellphone($item->phones->phone[1]);
                        }

                        $em->persist($people);
                        $em->flush();
                    }
                } catch (DBALException $ex) {
                    return new Response($ex->getMessage());
                }
            }

            if ($file->getName() == "shiporders") {
                try {
                    foreach ($file->shiporder as $items) {
                        /** @var \App\Entity\People $people */
                        $people = $this->getDoctrine()->getRepository(People::class)->find($items->orderperson);

                        if(!$people){
                            throw new DBALException("Person not found in database");
                        }

                        $adress = $items->shipto->address .', '.  $items->shipto->city .', '. $items->shipto->country;

                        foreach($items->items->item as $pieces){
                            $shiporder = new ShipOrder();
                            $shiporder->setAddress($adress);

                            $Item = new Item();
                            $Item->setName($pieces->title);
                            $Item->setNote($pieces->note);
                            $Item->setPrice(floatval($pieces->price));

                            $em->persist($Item);
                            $em->flush();

                            $shiporder->setItem($Item->getId());
                            $shiporder->setPeople($people->getId());

                            $em->persist($shiporder);
                            $em->flush();
                        }
                    }
                } catch (DBALException $ex) {
                    return new Response($ex->getMessage());
                }
            }

            $arrParams["success"] = true;
        }

        return $this->render('index/index.html.twig',$arrParams);
    }
}
