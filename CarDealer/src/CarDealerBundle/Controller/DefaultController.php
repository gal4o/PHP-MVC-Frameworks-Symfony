<?php

namespace CarDealerBundle\Controller;

use CarDealerBundle\Entity\Car;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction()
    {
        $cars = $this
            ->getDoctrine()
            ->getRepository(Car::class)
            ->findBy([],['model' => 'asc', 'travelledDistance' => 'desc']);
        return $this ->render('default/index.html.twig', ['cars' => $cars]);
    }

}
