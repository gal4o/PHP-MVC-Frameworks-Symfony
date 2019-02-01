<?php

namespace CarDealerBundle\Controller;

use CarDealerBundle\Entity\Customer;
use CarDealerBundle\Entity\Sale;
use CarDealerBundle\Form\CustomerType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Customer controller.
 **/
class CustomerController extends Controller
{
    /**
     * @Route("customers/all/{ord}", name="customers_all")
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
     * @Route("customers/{id}", name="customer_sales")
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

    /**
     * @Route("customer/add", name="customer_add")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function addCustomer(Request $request)
    {
        $customer = new Customer();
        $form = $this->createForm(CustomerType::class, $customer);
        $form->handleRequest($request);

        if ($form->isSubmitted()&&$form->isValid()) {
            if ($form->get('birthDate') >= '1998-01-01') // TUUUK
            {
                $customer->setIsYoungDriver('1');
            } else {
                $customer->setIsYoungDriver('0');
            }
            $em = $this->getDoctrine()->getManager();
            $em->persist($customer);
            $em->flush();
            return $this->redirectToRoute('customers_all', ['ord' => 'ascending']);
        }

        return $this->render('customer/add.html.twig',
            array('form' => $form->createView()));
    }

    /**
     * @Route("/customer/edit/{id}", name="customer_edit")
     * @param $id
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function editCustomer($id, Request $request)
    {
        $customer = $this->getDoctrine()
            ->getRepository(Customer::class)
            ->find($id);

        $form = $this->createForm(CustomerType::class, $customer);
        $form->handleRequest($request);
        if ($form->isSubmitted()&&$form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($customer);
            $em->flush();
            return $this->redirectToRoute('customer_sales',
                array('id' => $customer->getId()));
        }

        return $this->render('customer/edit.html.twig',
            array('customer' => $customer,
                'form' => $form->createView()));
    }

}
