<?php

namespace App\Controller;

use App\Entity\Week;
use App\Entity\Year;
use App\Entity\Payment;
use App\Entity\Inscription;
use App\Entity\InscriptionDetail;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
* @Route("/")
*/

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(EntityManagerInterface $manager): Response
    {
        $year = $manager->getRepository(Year::class)->findOneBy(['status' => 'true']);

        $weeks = $manager->getRepository(Week::class)->findBy(['year' => $year->getId()], ['weekNum'=>'ASC']);
            $inscDetails = $manager->getRepository(InscriptionDetail::class)->findBy(['year' => $year->getId()]);
            $totalExpected = $manager->getRepository(Inscription::class)->getTotalPaymentExceptedByYear(['year' => $year->getId()]);
            $totalPaid = $manager->getRepository(Payment::class)->getTotalPaidByYear(['year' => $year->getId()]);

        $totalColumns = $manager->getRepository(Inscription::class)->getTotalByColumnByYear(['year' => $year->getId()]);

        if (!$year) {
            $this->addFlash('error', 'Il n\'y a aucune Session active. S\'il vous plait sélectionnez-en une.');
            return $this->redirectToRoute('session_index');
        }

        return $this->render('home/index.html.twig', [
            'year' => $year,
            'weeks' => $weeks,
                'inscDetails' => $inscDetails,
                'totalPaid' => $totalPaid['total'],
                'totalExpected' => $totalExpected['total'],
            'totalColumns' => $totalColumns,
        ]);
    }
}
