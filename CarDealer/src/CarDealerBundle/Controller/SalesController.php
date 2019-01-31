<?php

namespace CarDealerBundle\Controller;

use CarDealerBundle\Entity\Sale;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class SalesController extends Controller
{
    /**
     * @Route("/Sales", name="sales_all")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
            $sales = $this->getDoctrine()
                ->getRepository(Sale::class)
                ->findAll();

            return $this->render('sales/index.html.twig',
                array('sales' => $sales));
    }

    /**
     * @Route("/Sales/{id}/{percent}", name="sales")
     * @param $id
     * @param $percent
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function oneSale($id, $percent = null)
    {
        if ($id==='discounted')
        {
            if ($percent!==null)
            {
                /** @var Sale[] $sales */
                $sales = $this->getDoctrine()
                    ->getRepository(Sale::class)
                    ->findWithDiscount($percent);

                return $this->render('sales/discounted.html.twig',
                    array('sales' => $sales));
            } else {
                /** @var Sale[] $sales */
                $sales = $this->getDoctrine()
                    ->getRepository(Sale::class)
                    ->findWithSomeDiscount();

                return $this->render('sales/discounted.html.twig',
                    array('sales' => $sales));
            }
        } else {
            $sale = $this->getDoctrine()
                ->getRepository(Sale::class)
                ->find($id);
            return $this->render('sales/one.html.twig',
                array('sale' => $sale));
        }
    }


//    /**
//     * @Route("/Sales/discounted", name="sales_discounted")
//     * @return \Symfony\Component\HttpFoundation\Response
//     */
//    public function discountedAction()
//    {
//        /** @var Sale[] $sales */
//        $sales = $this->getDoctrine()
//            ->getRepository(Sale::class)
//            ->findWithDiscount();
//
//        return $this->render('sales/discounted.html.twig',
//            array('sales' => $sales));
//    }
}
