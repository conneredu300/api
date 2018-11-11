<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ShipOrderRepository")
 */
class ShipOrder
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $people;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $address;

    /**
     * @ORM\Column(type="integer")
     */
    private $item;

    public function getId()
    {
        return $this->id;
    }

    public function getPeople()
    {
        return $this->people;
    }

    public function setPeople(int $people)
    {
        $this->people = $people;

        return $this;
    }

    public function getAddress()
    {
        return $this->address;
    }

    public function setAddress(string $address)
    {
        $this->address = $address;

        return $this;
    }

    public function getItem()
    {
        return $this->item;
    }

    public function setItem(int $item)
    {
        $this->item = $item;

        return $this;
    }
}
