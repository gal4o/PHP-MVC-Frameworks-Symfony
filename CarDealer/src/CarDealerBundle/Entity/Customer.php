<?php

namespace CarDealerBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Customer
 *
 * @ORM\Table(name="customers")
 * @ORM\Entity(repositoryClass="CarDealerBundle\Repository\CustomerRepository")
 */
class Customer
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="birthDate", type="datetime")
     */
    private $birthDate;

    /**
     * @var bool
     *
     * @ORM\Column(name="isYoungDriver", type="boolean")
     */
    private $isYoungDriver;

    /**
     * @var ArrayCollection|Sale[]
     * @ORM\OneToMany(targetEntity="CarDealerBundle\Entity\Sale", mappedBy="customer")
     */
    private $sales;

    public function __construct()
    {
        $this->sales = new ArrayCollection();
    }

    public function getTotalMoney()
    {
        $money = 0.00;
        foreach ($this->getSales() as $sale) {
            $money+=$sale->getSpentMoney();
        }
        return $money;
    }

    public function getNumberOfSales()
    {
        $count = count($this->getSales());
        return $count;
    }
    /**
     * @return Sale[]|ArrayCollection
     */
    public function getSales()
    {
        return $this->sales;
    }

    /**
     * @param $sale
     * @return Customer
     */
    public function addSale(Sale $sale)
    {
        $this->sales[] = $sale;
        return $this;
    }


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Customer
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set birthDate
     *
     * @param \DateTime $birthDate
     *
     * @return Customer
     */
    public function setBirthDate($birthDate)
    {
        $this->birthDate = $birthDate;

        return $this;
    }

    /**
     * Get birthDate
     *
     * @return \DateTime
     */
    public function getBirthDate()
    {
        return $this->birthDate;
    }

    /**
     * Set isYoundDriver
     *
     * @param boolean $isYoungDriver
     *
     * @return Customer
     */
    public function setIsYoungDriver($isYoungDriver)
    {
        $this->isYoungDriver = $isYoungDriver;

        return $this;
    }

    /**
     * Get isYoundDriver
     *
     * @return bool
     */
    public function getIsYoungDriver()
    {
        return $this->isYoungDriver;
    }
}

