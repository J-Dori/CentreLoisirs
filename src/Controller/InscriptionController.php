<?php

namespace App\Controller;

use App\Entity\Rate;
use App\Entity\Year;
use App\Entity\Payment;
use App\Entity\Inscription;
use App\Entity\Responsable;
use App\Form\InscriptionType;
use App\Entity\InscriptionDetail;
use App\Form\InscriptionEditType;
use App\Form\InscriptionDetailType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Cache\Persister\Collection;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
* @Route("/inscription")
*/

class InscriptionController extends AbstractController
{
    /**
     * @Route("/index", name="inscription_index")
     */
    public function index(EntityManagerInterface $manager): Response
    {
        $year = $manager->getRepository(Year::class)->findOneBy(['status' => 'true']);

        if (!$year) {
            $this->addFlash('error', 'Il n\'y a aucune Session active. S\'il vous plait sélectionnez-en une.');
            return $this->redirectToRoute('session_index');
        }

        return $this->render('inscription/index.html.twig', [
            'listing' => $manager->getRepository(Inscription::class)->findBy(['year' => $year->getId()]),
            'activeYear' => $year->getYear()
        ]);
    }

    /**
     * @Route("/add", name="inscription_add")
     */
    public function addInscription(Inscription $entity = null, Request $request, EntityManagerInterface $manager): Response
    {
        $year = $manager->getRepository(Year::class)->findOneBy(['status' => 'true']);

        //Each Session starts with Inscription nº at 1 (one), here we get manual incrementation 
        $getLastNum = $manager->getRepository(Inscription::class)->findLastNumInscription($year->getId());
        if ($getLastNum == null)
            $lastNum = 1; //1st of Session
        else
            $lastNum = $getLastNum->getNumInsc()+1; //incrementation

        if (!$entity) {
            $entity = new Inscription();
        }

        $form = $this->createForm(InscriptionType::class, $entity, ['yearId'=>$year->getId() , 'lastNum'=>$lastNum]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $rate = $manager->getRepository(Rate::class)->findOneBy(['id'=>$form['rate']->getData()->getId()]);
            $responsable = $manager->getRepository(Responsable::class)->findOneBy(['id'=>$form['responsable']->getData()->getId()]);

            $entity->setNumInsc($lastNum);
            $entity->setRate($rate);
            $entity->setResponsable($responsable);
            $entity->setYear($year);
            $manager->persist($entity);
            $manager->flush();

            $calculate = $this->calculate($entity, $manager);            

            //updates values only after Flush to be able to recover all selected fields to Calculate totals
            $manager->getRepository(Inscription::class)->updatePrices(
                        $entity->getId(), 
                        $calculate['totalWeekPrice'], 
                        $calculate['totalMeals'], 
                        $entity->getYear()->getPriceInscription(), 
                        $calculate['totalToPay']
            );
            $manager->getRepository(InscriptionDetail::class)->setYearNewInscription($entity->getId(), $year->getId());

            return $this->redirectToRoute('inscription_edit', ['id' => $entity->getId()]);
        }

        return $this->render('inscription/form.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/edit/{id}", name="inscription_edit", requirements={"id"="\d+"})
     */
    public function editInscription(Inscription $entity, Request $request, EntityManagerInterface $manager): Response
    {
        $year = $entity->getYear();
        
        $form = $this->createForm(InscriptionEditType::class, $entity, ['yearId' => $year->getId()]);
        $form->handleRequest($request);

        $calculate = $this->calculate($entity, $manager);

        if ($request->query->get('addData')) {
            $calculate = $this->calculate($entity, $manager);                
            $entity->setTotalWeek($calculate['totalWeekPrice']);
            $entity->setQttMeal($calculate['totalMeals']);
            $entity->setPriceInsc($entity->getYear()->getPriceInscription());
            $entity->setTotalInsc($calculate['totalToPay']);
            $manager->persist($entity);
            $manager->flush();
            $this->addFlash('success', 'ATTENTION : Les montants ont été mises à jour avec les valeurs par défault.');
            return $this->redirectToRoute('inscription_edit', ['id' => $entity->getId()]);
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $rate = $manager->getRepository(Rate::class)->findOneBy(['id'=>$form['rate']->getData()->getId()]);
            $responsable = $manager->getRepository(Responsable::class)->findOneBy(['id'=>$form['responsable']->getData()->getId()]);

            $entity->setRate($rate);
            $entity->setResponsable($responsable);
            $entity->setYear($year);

            if ($form->get('save')->isClicked()) // Send to PaymentForm
            {
                $calculate = $this->calculate($entity, $manager);                
                $entity->setTotalWeek($calculate['totalWeekPrice']);
                $entity->setQttMeal($calculate['totalMeals']);
                $entity->setPriceInsc($entity->getYear()->getPriceInscription());
                $entity->setTotalInsc($calculate['totalToPay']);
                $manager->persist($entity);
                $manager->flush();
                return $this->redirectToRoute('inscription_edit', ['id' => $entity->getId()]);
            }

            if ($form->get('update')->isClicked()) // Send to PaymentForm
            {
                $calculate = $this->calculate($entity, $manager);
                $totalToPay = $form['totalWeek']->getData();
                $totalToPay += $form['qttMeal']->getData() * $entity->getYear()->getPriceMeal();
                $totalToPay += $form['priceInsc']->getData();
                $entity->setTotalInsc($totalToPay);
            }

            if ($form->get('saveAndPay')->isClicked()) // Send to PaymentForm
            {
                return $this->redirectToRoute('payment_index', ['id' => $entity->getId()]);
            }

            $manager->persist($entity);
            $manager->flush();

            return $this->redirectToRoute('inscription_edit', ['id' => $entity->getId()]);
        }

        $pageTitle = "INSCRIPTION Nº ". $entity->getNumInsc() ." / ". $year->getYear();
        return $this->render('inscription/formEdit.html.twig', [
            'form' => $form->createView(),
            'inscID' => $entity->getId(),
            'pageTitle' => $pageTitle,
            'inscriptionDetails' => $entity->getInscriptionDetails(),
            'priceMeal' => $entity->getYear()->getPriceMeal(),
            'totalChildren' => $calculate['totalChildren'],
            'totalWeek' => $calculate['totalWeek'],
            'totalWeekPrice' => $calculate['totalWeekPrice'],
            'ratePrice' => $calculate['getRate']
        ]);
    }


    /**
     * @Route("/addChildren", name="inscription_addChildren")
     * @Route("/editChildren/{id}", name="inscription_editChildren", requirements={"id"="\d+"})
     */
    public function addChildren(InscriptionDetail $entity = null, Request $request, EntityManagerInterface $manager): Response
    {
        $inscription = $manager->getRepository(Inscription::class)->findOneBy(['id' => $request->query->get('insc')]);

        if (!$entity) {
            $entity = new InscriptionDetail();
        }

        $form = $this->createForm(InscriptionDetailType::class, $entity, ['yearId' => $inscription->getYear()->getId()]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entity->setInscription($inscription);
            $entity->setYear($inscription->getYear());
            $manager->persist($entity);
            $manager->flush();
            return $this->redirectToRoute('inscription_edit', ['id'=>$inscription->getId(), 'addData'=>true]);
        }

        $pageTitle = "INSCRIPTION Nº ". $inscription->getNumInsc() ." / ". $inscription->getYear()->getYear();
        return $this->render('inscription/formAddChildren.html.twig', [
            'form' => $form->createView(),
            'pageTitle' => $pageTitle,
            'inscID' => $inscription->getId(),
        ]);
    }

   
    public function calculate(Inscription $entity = null, EntityManagerInterface $manager)
    {
        //Get totals of diferent Children * count total Weeks
        $totalChildren = $manager->getRepository(InscriptionDetail::class)->getTotalChildren($entity->getId());
        $totalWeek = $manager->getRepository(InscriptionDetail::class)->getTotalWeek($entity->getId());

        //Get Rate : RateID selected and by number of Children (totalChildren)
        $getRate = $manager->getRepository(Rate::class)->getRateByInscription($entity->getRate(), $totalChildren['total']);
        //$field -> to get the array key of $getRate, ex : $getRate['child1'] or $getRate['child2'] etc...
        $field = "child".$totalChildren['total'];   
        
        $totalMeals = 0;
        //Get number of days of each WEEK (countDays) and add if WithMeal=true
        foreach ($entity->getInscriptionDetails() as $key => $value) {
            if ($value->getWithMeal())
                $totalMeals += $value->getWeek()->countDays();
        }

        $totalWeekPrice = $getRate[$field] * $totalWeek['total'];
        $totalToPay = ($totalWeekPrice) + 
                      ($entity->getYear()->getPriceMeal() * $totalMeals) + 
                      $entity->getYear()->getPriceInscription();

        return [
                'totalChildren' => $totalChildren['total'], 
                'totalWeek'     => $totalWeek['total'], 
                'totalWeekPrice'=> $totalWeekPrice, 
                'getRate'       => $getRate[$field], 
                'totalMeals'    => $totalMeals, 
                'totalToPay'    => $totalToPay
        ];
    }

}
