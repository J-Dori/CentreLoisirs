<?php

namespace App\Controller;

use App\Entity\Year;
use App\Entity\ArrayList;
use App\Form\ArrayListType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
* @Route("/arrayList/year")
*/

class ArrayListController extends AbstractController
{
    /**
     * @Route("/{id}", name="arrayList", requirements={"id"="\d+"})
     */
    public function index(Request $request, EntityManagerInterface $manager): Response
    {
        $yearId = $request->attributes->get('id');

        return $this->render('session/arrayList/index.html.twig', [
            'arrayList' => $manager->getRepository(ArrayList::class)->findOneBy(['year'=>$yearId]),
        ]);
    }

    /**
     * @Route("/{id}/add", name="arrayList_add")
     * @Route("/{id}/edit", name="arrayList_edit", requirements={"id"="\d+"})
     */
    public function addArrayList(ArrayList $entity = null, Request $request, EntityManagerInterface $manager): Response
    {
        $year = $request->attributes->get('id');

        if (!$entity) {
            $entity = new ArrayList();
        }
                
        $form = $this->createForm(ArrayListType::class, $entity);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entity->setYear($manager->getRepository(Year::class)->findOneBy(['id'=>$year]));
            $manager->persist($entity);
            $manager->flush();

            $this->addFlash("success", "Données enregistrées");
            return $this->redirectToRoute('year_index', ['id'=>$year]);
        }

        return $this->render('session/arrayList/form.html.twig', [
            'form' => $form->createView(),
            'editMode' => $entity->getId() !== null,
        ]);
    }

}
