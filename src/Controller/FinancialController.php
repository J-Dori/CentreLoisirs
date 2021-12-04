<?php

namespace App\Controller;

use App\Entity\Year;
use App\Entity\FinIncome;
use App\Entity\FinExpense;
use App\Entity\FinCategory;
use App\Form\FinIncomeType;
use App\Form\FinExpenseType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


/**
* @Route("/financier")
*/
class FinancialController extends AbstractController
{
    /**
     * @Route("/", name="financial_index")
     */
    public function index(EntityManagerInterface $manager): Response
    {
        $year = $manager->getRepository(Year::class)->findOneBy(['status' => 'true']);
        $totalIncome = $manager->getRepository(FinIncome::class)->totalByYear($year->getId());
        $totalExpense = $manager->getRepository(FinExpense::class)->totalByYear($year->getId());

        return $this->render('financial/index.html.twig', [
            'incomes' => $manager->getRepository(FinIncome::class)->findBy(['year' => $year->getId()], ['dateIn'=>'DESC']),
            'expenses' => $manager->getRepository(FinExpense::class)->findBy(['year' => $year->getId()], ['dateIn'=>'DESC']),
            'totalIncome' => $totalIncome['total'],
            'totalExpense' => $totalExpense['total'],
            'year' => $year->getYear()
        ]);
    }


/************************************** INCOME **************************************/
    /**
     * @Route("/recette/add", name="income_add")
     * @Route("/recette/edit/{id}", name="income_edit", requirements={"id"="\d+"})
     */
    public function add_editIncome(FinIncome $entity = null, Request $request, EntityManagerInterface $manager): Response
    {
        $year = $manager->getRepository(Year::class)->findOneBy(['status' => 'true']);

        $lastNum = null;

        if (!$entity) {
            $entity = new FinIncome();
            //Each Session starts with Income nº at 1 (one), here we get manual incrementation 
            $getLastNum = $manager->getRepository(FinIncome::class)->findLastNum($year->getId());
            if ($getLastNum == null)
                $lastNum = 1; //1st of Session
            else
                $lastNum = $getLastNum->getNumInc()+1; //incrementation
        }
        else
            $lastNum = (int)$entity->getNumInc();


        $form = $this->createForm(FinIncomeType::class, $entity, ['yearId'=>$year->getId() , 'lastNum'=>$lastNum]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entity->setYear($year);
            $manager->persist($entity);
            $manager->flush();

            $this->addFlash('success', 'Recette nº '. $lastNum .' enregistré');
            return $this->redirectToRoute('financial_index');
        }

        return $this->render('financial/formIncome.html.twig', [
            'form' => $form->createView(),
            'year' => $year->getYear()
        ]);
    }

/************************************** EXPENSE **************************************/
    /**
     * @Route("/depenses/add", name="expense_add")
     * @Route("/depenses/edit/{id}", name="expense_edit", requirements={"id"="\d+"})
     */
    public function add_editExpense(FinExpense $entity = null, Request $request, EntityManagerInterface $manager): Response
    {
        $year = $manager->getRepository(Year::class)->findOneBy(['status' => 'true']);

        $lastNum = null;

        if (!$entity) {
            $entity = new FinExpense();
            //Each Session starts with Expense nº at 1 (one), here we get manual incrementation 
            $getLastNum = $manager->getRepository(FinExpense::class)->findLastNum($year->getId());
            if ($getLastNum == null)
                $lastNum = 1; //1st of Session
            else
                $lastNum = $getLastNum->getNumExp()+1; //incrementation
        }
        else
            $lastNum = (int)$entity->getNumExp();

        $form = $this->createForm(FinExpenseType::class, $entity, ['yearId'=>$year->getId() , 'lastNum'=>$lastNum]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $entity->setYear($year);
            $manager->persist($entity);
            $manager->flush();

            $this->addFlash('success', 'Dépense nº '. $lastNum .' enregistrée');
            return $this->redirectToRoute('financial_index');
        }

        return $this->render('financial/formExpense.html.twig', [
            'form' => $form->createView(),
            'year' => $year->getYear()
        ]);
    }


/************************************** CATEGORY **************************************/
    /**
     * @Route("/categories", name="category_index")
     */
    public function indexCategory(EntityManagerInterface $manager): Response
    {
        return $this->render('financial/category/index.html.twig', [
            'categories' => $manager->getRepository(FinCategory::class)->findBy([],['title'=>'ASC'])
        ]);
    }

    /**
     * @Route("/categories/add", name="category_add") 
     * @Route("/categories/edit/{id}", name="category_edit", requirements={"id"="\d+"})
     */
    public function formCategory(FinCategory $category = null, Request $request, EntityManagerInterface $manager): Response
    {
        if (!$category) {
            $category = new FinCategory();
        }

        $form = $this->createFormBuilder($category)
            ->add('title', TextType::class)            
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($category);
            $manager->flush();

            return $this->redirectToRoute('category_index');
        }

        return $this->render('financial/category/formCategory.html.twig', [
            'form' => $form->createView(),
            'categories' => $manager->getRepository(FinCategory::class)->findBy([],['title'=>'ASC'])
        ]);
    }

    /**
     * @Route("/categorie/{id}", name="category_del", requirements={"id"="\d+"})
     */
    public function delCategory(FinCategory $entity = null, EntityManagerInterface $manager): Response
    {
        //@TODO -> check if category is already attributed to Inc/Expenses, if YES = CANT DELETE
        $manager->remove($entity);
        $manager->flush();
        return $this->redirectToRoute('category_index');
    }

}
