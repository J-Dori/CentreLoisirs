<?php

namespace App\Controller;

use App\Entity\Payment;
use App\Form\PaymentType;
use App\Entity\Inscription;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
* @Route("/paiements")
*/

class PaymentController extends AbstractController
{
    /**
     * @Route("/inscription/{id}", name="payment_index", requirements={"id"="\d+"})
     */
    public function paymentIndex(Request $request, EntityManagerInterface $manager): Response
    {
        $idInsc = $request->attributes->get('id'); //inscription
        $inscription = $manager->getRepository(Inscription::class)->findOneBy(['id'=>$idInsc]);
        $totalPaid = $manager->getRepository(Payment::class)->getTotalPaid($idInsc);
        $pageTitle = "INSCRIPTION Nº ". $inscription->getNumInsc() ." / ". $inscription->getYear()->getYear(); 
        return $this->render('payment/index.html.twig', [
            'inscription' => $inscription,
            'totalPaid' => $totalPaid['total'],
            'pageTitle' => $pageTitle,
        ]);
    }


    /**
     * @Route("/add/{id}", name="payment_add")
     */
    public function addPayment(Payment $entity = null, Request $request, EntityManagerInterface $manager): Response
    {
        $idInsc = $request->attributes->get('id'); //inscription
        $inscription = $manager->getRepository(Inscription::class)->findOneBy(['id'=>$idInsc]);

        $entity = new Payment();
        
        $form = $this->createForm(PaymentType::class, $entity);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entity->setInscription($inscription);
            $manager->persist($entity);
            $manager->flush();

            $this->addFlash("success", "Paiement enregistré");
            return $this->redirectToRoute('payment_index', ['id' => $inscription->getId()]);
        }

        $pageTitle = "INSCRIPTION Nº ". $inscription->getNumInsc() ." / ". $inscription->getYear()->getYear(); 
        $totalPaid = $manager->getRepository(Payment::class)->getTotalPaid($idInsc);
        return $this->render('payment/formPay.html.twig', [
            'form' => $form->createView(),
            'pageTitle' => $pageTitle,
            'inscription' => $inscription,
            'idInsc' => $idInsc,
            'totalPaid' => $totalPaid['total'],
        ]);
    }

    /**
     * @Route("/delete/{id}", name="payment_del", requirements={"id"="\d+", "insc"="\d+"})
     */
    public function delPayment(Payment $entity = null, Request $request, EntityManagerInterface $manager): Response
    {
        $idInsc = $request->query->get('insc'); //inscription
        $manager->remove($entity);
        $manager->flush();
        return $this->redirectToRoute('payment_index', ['id' => $idInsc]);
    }

}
