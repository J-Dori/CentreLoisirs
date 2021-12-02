<?php

namespace App\Controller;

use App\Entity\Rate;
use App\Entity\Week;
use App\Entity\Year;
use App\Form\RateType;
use App\Form\WeekType;

use App\Form\YearType;
use App\Entity\AgeGroup;
use App\Entity\ArrayList;
use App\Form\AgeGroupType;
use App\Form\ContractType;

use App\Form\YearCopyType;
use App\Entity\AnimateurContract;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
* @Route("/sessions")
*/

class SessionController extends AbstractController
{
    /**
     * @Route("/", name="session_index")
     */
    public function index(): Response
    {
        return $this->render('session/index.html.twig', [
            'listing' => $this->getDoctrine()->getRepository(Year::class)->findAll(),
        ]);
    }

    /**
     * @Route("/year/{id}", name="year_index", requirements={"id"="\d+"})
     */
    public function indexYear(Request $request, EntityManagerInterface $manager): Response
    {
        $yearId = $request->attributes->get('id');

        return $this->render('session/year/index.html.twig', [
            'year' => $manager->getRepository(Year::class)->findOneBy(['id'=>$yearId]),
            'weeksList' => $manager->getRepository(Week::class)->findBy(['year'=>$yearId]),
            'ageList' => $manager->getRepository(AgeGroup::class)->findBy(['year'=>$yearId]),
            'rateList' => $manager->getRepository(Rate::class)->findBy(['year'=>$yearId]),
            'contractList' => $manager->getRepository(AnimateurContract::class)->findBy(['year'=>$yearId]),
            'arrayList' => $manager->getRepository(ArrayList::class)->findBy(['year'=>$yearId]),
        ]);
    }

    /**
     * @Route("/year/active/{id}", name="session_activeYear", requirements={"id"="\d+"})
     */
    public function activeYear(Request $request, EntityManagerInterface $manager): Response
    {
        $yearId = $request->attributes->get('id');
        $back = $request->query->get('back');

        $manager->getRepository(Year::class)->activeYear($yearId);
        $active = $manager->getRepository(Year::class)->findOneBy(['status' => 'true']);

        $this->addFlash('success', 'Session '. $active->getYear() .' est ouverte');

        if ($back == 'year')
            return $this->redirectToRoute('year_index', ['id' => $yearId]);

        return $this->redirectToRoute('session_index');
    }

    //**************************************** YEAR ***********************************************/
    //********************************************************************************************/
    /**
     * @Route("/year/add", name="year_add")
     * @Route("/year/{id}/edit", name="year_edit", requirements={"id"="\d+"})
     */
    public function addYear(Year $entity = null, Request $request, EntityManagerInterface $manager): Response
    {
        if (!$entity) {
            $entity = new Year();
        }
                
        $form = $this->createForm(YearType::class, $entity);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $manager->persist($entity);
            $manager->flush();

            return $this->redirectToRoute('year_index', ['id'=>$entity->getId()]);
        }

        return $this->render('session/year/form.html.twig', [
            'form' => $form->createView(),
            'editMode' => $entity->getId() !== null,
        ]);
    }

    /**
     * @Route("/year/copy/{id}", name="year_copy", requirements={"id"="\d+"})
     */
    public function addYearCopy(Year $entity = null, Request $request, EntityManagerInterface $manager): Response
    {
        $fromYear = $request->attributes->get('id');
        $copyYear = $manager->getRepository(Year::class)->copyYear($fromYear);

        $entity = new Year();

        $form = $this->createForm(YearCopyType::class, $entity, ['copyYear'=>$copyYear]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entity->setStatus(false);
            $manager->persist($entity);
            $manager->flush();

            //get newYear ID after flush and get ArrayList fromYear selected to duplicate the values, except Year that gets newYear
            $newYear = $manager->getRepository(Year::class)->findOneBy(['id'=>$entity->getId()]);
            $copy = $manager->getRepository(ArrayList::class)->findOneBy(['year'=>$fromYear]);

            if (!$copy) {
                $this->addFlash('error', 'L\'année sélectionnée n\'avait aucuns Champs Prédéfinis à copier');
            } else {
                $newArrayList = new ArrayList($copy);
                $newArrayList->setRateTitle($copy->getRateTitle());
                $newArrayList->setAgeGroup($copy->getAgeGroup());
                $newArrayList->setTypeContract($copy->getTypeContract());
                $newArrayList->setweekType($copy->getWeekType());
                $newArrayList->setYear($newYear);
                $manager->persist($newArrayList);
                $manager->flush();
                $this->addFlash('success', 'Les Champs Prédéfinis ont été copier vers l\'année '. $entity->getYear());
            }
            return $this->redirectToRoute('year_index', ['id'=>$entity->getId()]);
        }

        return $this->render('session/year/form.html.twig', [
            'form' => $form->createView(),
            'editMode' => 'copy'
        ]);
    }

    //**************************************** WEEK ***********************************************/
    //********************************************************************************************/
    /**
     * @Route("/week/add/year/{id}", name="week_add")
     * @Route("/week/{id}/edit", name="week_edit", requirements={"id"="\d+"})
     */
    public function addWeek(Week $entity = null, Request $request, EntityManagerInterface $manager): Response
    {
        $getID = $request->query->get('year'); //editMode = gets Year ID

        if (!$entity) {
            $entity = new Week();
            $getID = $request->attributes->get('id'); //addMode gets Week ID
        }

        //get values of ArrayList
        $year = $manager->getRepository(Year::class)->findOneBy(['id'=>$getID]);
        $arrayList = $manager->getRepository(ArrayList::class)->findOneBy(['year' => $year]);
        //get values of ArrayList - column
        $titles = $arrayList->getWeekType();
        //transform array Keys to be equal to column text instead of 0,1,...
        $titles = array_combine($titles, $titles);

        $form = $this->createForm(WeekType::class, $entity, ['yearId'=>$getID, 'titles' => $titles]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entity->setYear($this->getDoctrine()->getRepository(Year::class)->findOneBy(['id'=>$getID]));
            $manager->persist($entity);
            $manager->flush();

            $this->addFlash("success", "Données enregistrées");
            return $this->redirectToRoute('year_index', ['id'=> (int)$getID]);
        }

        return $this->render('session/week/form.html.twig', [
            'form' => $form->createView(),
            'editMode' => $entity->getId() !== null,
        ]);
    }

    //**************************************** AGE GROUP ***********************************************/
    //********************************************************************************************/
    /**
     * @Route("/ageGroup/add/year/{id}", name="ageGroup_add")
     * @Route("/ageGroup/{id}/edit", name="ageGroup_edit", requirements={"id"="\d+"})
     */
    public function addAgeGroup(AgeGroup $entity = null, Request $request, EntityManagerInterface $manager): Response
    {
        $yearId = $request->query->get('year'); //editMode

        if (!$entity) {
            $entity = new AgeGroup();
            $yearId = $request->attributes->get('id'); //addMode
        }

        //get values of ArrayList
        $year = $manager->getRepository(Year::class)->findOneBy(['id'=>$yearId]);
        $arrayList = $manager->getRepository(ArrayList::class)->findOneBy(['year' => $year]);
        //get values of ArrayList - column
        $titles = $arrayList->getAgeGroup();
        //transform array Keys to be equal to column text instead of 0,1,...
        $titles = array_combine($titles, $titles);

        $form = $this->createForm(AgeGroupType::class, $entity, ['yearId'=>$yearId, 'titles' => $titles]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entity->setYear($this->getDoctrine()->getRepository(Year::class)->findOneBy(['id'=>$yearId]));
            $manager->persist($entity);
            $manager->flush();

            $this->addFlash("success", "Données enregistrées");
            return $this->redirectToRoute('year_index', ['id'=> (int)$yearId]);
        }

        return $this->render('session/ageGroup/form.html.twig', [
            'form' => $form->createView(),
            'editMode' => $entity->getId() !== null,
        ]);
    }

    //**************************************** RATES ***********************************************/
    //********************************************************************************************/
     /**
     * @Route("/rate/add/year/{id}", name="rate_add")
     * @Route("/rate/{id}/edit", name="rate_edit", requirements={"id"="\d+"})
     */
    public function addRate(Rate $entity = null, Request $request, EntityManagerInterface $manager): Response
    {
        $yearId = $request->query->get('year'); //editMode

        if (!$entity) {
            $entity = new Rate();
            $yearId = $request->attributes->get('id'); //addMode
        }

        //get values of ArrayList
        $year = $manager->getRepository(Year::class)->findOneBy(['id'=>$yearId]);
        $arrayList = $manager->getRepository(ArrayList::class)->findOneBy(['year' => $year]);
        //get values of ArrayList - column
        $titles = $arrayList->getRateTitle();
        //transform array Keys to be equal to column text instead of 0,1,...
        $titles = array_combine($titles, $titles);

        $form = $this->createForm(RateType::class, $entity, ['yearId'=>$yearId, 'titles' => $titles]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entity->setYear($this->getDoctrine()->getRepository(Year::class)->findOneBy(['id'=>$yearId]));
            $manager->persist($entity);
            $manager->flush();

            $this->addFlash("success", "Données enregistrées");
            return $this->redirectToRoute('year_index', ['id'=> (int)$yearId]);
        }

        return $this->render('session/rate/form.html.twig', [
            'form' => $form->createView(),
            'editMode' => $entity->getId() !== null,
        ]);
    }


    //**************************************** CONTRACTS ***********************************************/
    //********************************************************************************************/
     /**
     * @Route("/contract/add/year/{id}", name="contract_add")
     * @Route("/contract/{id}/edit", name="contract_edit", requirements={"id"="\d+"})
     */
    public function addContract(AnimateurContract $entity = null, Request $request, EntityManagerInterface $manager): Response
    {
        $yearId = $request->query->get('year'); //editMode

        if (!$entity) {
            $entity = new AnimateurContract();
            $yearId = $request->attributes->get('id'); //addMode
        }

        //get values of ArrayList
        $year = $manager->getRepository(Year::class)->findOneBy(['id'=>$yearId]);
        $arrayList = $manager->getRepository(ArrayList::class)->findOneBy(['year' => $year]);
        //get values of ArrayList - column
        $titles = $arrayList->getTypeContract();
        //transform array Keys to be equal to column text instead of 0,1,...
        $titles = array_combine($titles, $titles);

        $form = $this->createForm(ContractType::class, $entity, ['yearId'=>$yearId, 'titles' => $titles]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entity->setYear($this->getDoctrine()->getRepository(Year::class)->findOneBy(['id'=>$yearId]));
            $manager->persist($entity);
            $manager->flush();

            $this->addFlash("success", "Données enregistrées");
            return $this->redirectToRoute('year_index', ['id'=> (int)$yearId]);
        }

        return $this->render('session/contract/form.html.twig', [
            'form' => $form->createView(),
            'editMode' => $entity->getId() !== null,
        ]);
    }
}
