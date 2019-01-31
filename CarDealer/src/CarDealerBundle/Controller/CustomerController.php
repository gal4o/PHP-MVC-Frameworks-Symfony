<?php

namespace CarDealerBundle\Controller;

use CarDealerBundle\Entity\Customer;
use CarDealerBundle\Entity\Sale;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Customer controller.
 *
 * @Route("customers")
 */
class CustomerController extends Controller
{
    /**
     * @Route("/all/{ord}", name="customers_all")
     * @param string $ord
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction($ord)
    {
        if ($ord == 'ascending')
        {
            $ord = 'ASC';
        } else {
            $ord = 'DESC';
        }

        $customers = $this
            ->getDoctrine()
            ->getRepository(Customer::class)
            ->getAllCustomers($ord);

        return $this->render('customer/index.html.twig', [
            'customers' => $customers
        ]);
    }

    /**
     * @Route("/{id}", name="customer_sales")
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function totalSales($id)
    {
        $customer = $this
            ->getDoctrine()
            ->getRepository(Customer::class)
            ->find($id);

        /** @var Sale[] $sales */
        $sales = $this->getDoctrine()
            ->getRepository(Sale::class)
            ->findBy(['customer' => $customer->getId()]);

        return $this->render('customer/sales.html.twig', [
            'customer' => $customer, 'sales' => $sales
        ]);
    }
}
