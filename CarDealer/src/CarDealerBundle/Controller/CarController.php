<?php

namespace CarDealerBundle\Controller;

use CarDealerBundle\Entity\Car;
use CarDealerBundle\Entity\Part;
use CarDealerBundle\Form\CarType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CarController extends Controller
{
    /**
     * @Route("cars/{make}", name="cars_make")
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
     * @Route("cars/{id}/parts", name="cars_parts")
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

    /**
     * @Route("car/add", name="car_add")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function addCar(Request $request)
    {
        $car = new Car();
        $form = $this->createForm(CarType::class, $car);
        $form->handleRequest($request);
        $parts = $this->getDoctrine()
            ->getRepository(Part::class)
            ->findAll();

        if ($form->isSubmitted()&&$form->isValid()) {
            $parts = $this->getDoctrine()
                ->getRepository(Part::class)
                ->findBy(['id' => $request->get('parts')]);
            foreach ($parts as $part) {
                $car->addPart($part);
            }
            $em = $this->getDoctrine()->getManager();
            $em->persist($car);
            $em->flush();
            return $this->redirectToRoute('homepage');
        }

        return $this->render('car/add.html.twig',
            array('form' => $form->createView(), 'parts' => $parts));
    }
}
