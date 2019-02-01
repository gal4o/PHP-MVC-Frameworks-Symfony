<?php

namespace CarDealerBundle\Controller;


use CarDealerBundle\Entity\Part;
use CarDealerBundle\Entity\Supplier;
use CarDealerBundle\Form\PartType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class PartController extends Controller
{
    /**
     * @Route("parts/all", name="parts_all")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        $parts = $this
            ->getDoctrine()
            ->getRepository(Part::class)
            ->findAll();

        return $this->render('part/index.html.twig', [
            'parts' => $parts
        ]);
    }

    /**
     * @Route("part/add", name="part_add")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function addPart(Request $request)
    {
        $part = new Part();
        $form = $this->createForm(PartType::class, $part);
        $form->handleRequest($request);
        $suppliers = $this->getDoctrine()
            ->getRepository(Supplier::class)
            ->findAll();
        if ($form->isSubmitted()&&$form->isValid()) {
            $supplier = $this
                ->getDoctrine()
                ->getRepository(Supplier::class)
                ->findOneBy(['name' => $request->get('supplier')]);
            $part->setSupplier($supplier);
            $em = $this->getDoctrine()->getManager();
            $em->persist($part);
            $em->flush();
            return $this->redirectToRoute('parts_all');
        }

        return $this->render('part/add.html.twig',
            array('form' => $form->createView(), 'suppliers' => $suppliers));
    }

    /**
     * @Route("/part/edit/{id}", name="part_edit")
     * @param $id
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function editPart($id, Request $request)
    {
        $part = $this->getDoctrine()
            ->getRepository(Part::class)
            ->find($id);

        $form = $this->createForm(PartType::class, $part);
        $form->handleRequest($request);

        if ($form->isSubmitted()&&$form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($part);
            $em->flush();
            return $this->redirectToRoute('parts_all');
        }

        return $this->render('part/edit.html.twig',
            array('part' => $part,
                'form' => $form->createView()));
    }

    /**
     * @Route("/part/delete/{id}", name="part_delete")
     * @param $id
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function deletePart($id, Request $request)
    {
        $part = $this->getDoctrine()
            ->getRepository(Part::class)
            ->find($id);

        $form = $this->createForm(PartType::class, $part);
        $form->handleRequest($request);

        if ($form->isSubmitted()&&$form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->remove($part);
            $em->flush();
            return $this->redirectToRoute('parts_all');
        }

        return $this->render('part/delete.html.twig',
            array('part' => $part,
                'form' => $form->createView()));
    }
}