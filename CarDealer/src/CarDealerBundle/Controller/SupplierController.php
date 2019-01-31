<?php

namespace CarDealerBundle\Controller;

use CarDealerBundle\Entity\Part;
use CarDealerBundle\Entity\Supplier;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class SupplierController extends Controller
{
    /**
     * @Route("/suppliers/{isImporter}", name="supplier_index")
     * @param $isImporter
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction($isImporter)
    {
        if ($isImporter == 'importers') {
            $isImporter = 1;
        } else {
            $isImporter = 0;
        }

    /** @var Supplier[] $suppliers */
        $suppliers = $this
            ->getDoctrine()
            ->getRepository(Supplier::class)
            ->findBy(['isImporter' => $isImporter]);

        return $this->render('supplier/index.html.twig', ['suppliers' => $suppliers]);
    }

}
