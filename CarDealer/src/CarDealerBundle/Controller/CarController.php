<?php

namespace CarDealerBundle\Controller;

use CarDealerBundle\Entity\Car;
use CarDealerBundle\Entity\Part;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class CarController extends Controller
{
    /**
     * @Route("/car/index", name="car_index")
     */
    public function indexAction()
    {
        $cars = $this
            ->getDoctrine()
            ->getRepository(Car::class)
            ->findBy([],['model' => 'asc', 'travelledDistance' => 'desc']);
        return $this ->render('default/index.html.twig', ['cars' => $cars]);
    }

    /**
     * @Route("/cars/{make}", name="cars_make")
     * @param $make
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getCarsByMake($make)
    {
        $cars = $this
            ->getDoctrine()
            ->getRepository(Car::class)
            ->findByMake($make);
        return $this->render('car/make.html.twig', ['cars' =>$cars]);
    }

    /**
     * @Route("/cars/{id}/parts", name="cars_parts")
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getCarsWithParts($id)
    {
        /** @var Car[] $cars */
        $cars = $this
            ->getDoctrine()
            ->getRepository(Car::class)
            ->findByPart($id);

        return $this->render('car/parts.html.twig', ['cars' => $cars]);
    }
}
