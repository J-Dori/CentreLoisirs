<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Children;
use App\Entity\Animateur;
use App\Form\UserAddType;
use App\Form\ChildrenType;
use App\Form\UserEditType;
use App\Entity\Responsable;
use App\Form\AnimateurType;
use App\Form\ResponsableType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
* @Route("/donnees")
*/

class PeopleController extends AbstractController
{
    /**
     * @Route("/", name="people_index")
     */
    public function index(): Response
    {
        return $this->render('people/index.html.twig', [
            'controller_name' => 'FamilyController',
        ]);
    }

    /**
     * @Route("/responsables", name="responsable_index")
     */
    public function responsable_index(): Response
    {
        return $this->render('people/responsable/responsable.html.twig', [
            'listing' => $this->getDoctrine()->getRepository(Responsable::class)->findAll()
        ]);
    }

    /**
     * @Route("/enfants", name="children_index")
     */
    public function children_index(): Response
    {
        return $this->render('people/children/children.html.twig', [
            'listing' => $this->getDoctrine()->getRepository(Children::class)->findAll()
        ]);
    }

    /**
     * @Route("/animateurs", name="animateur_index")
     */
    public function animateur_index(): Response
    {
        return $this->render('people/animateur/animateur.html.twig', [
            'listing' => $this->getDoctrine()->getRepository(Animateur::class)->findAll()
        ]);
    }

    /**
     * @Route("/utilisateurs", name="user_index")
     */
    public function user_index(): Response
    {
        return $this->render('people/user/user.html.twig', [
            'listing' => $this->getDoctrine()->getRepository(User::class)->findAll()
        ]);
    }

    //************************************** PROFILES ********************************************/
    //********************************************************************************************/

    /**
     * @Route("/responsable/{id}", name="responsable_profile", methods="GET", requirements={"id"="\d+"})
     */
    public function responsableProfile(Responsable $responsable): Response
    {
        return $this->render('people/responsable/profile.html.twig', [
                'profile' => $this->getDoctrine()->getRepository(Responsable::class)->find($responsable->getId()),
            ]);
    }

    /**
     * @Route("/enfants/{id}", name="children_profile", methods="GET", requirements={"id"="\d+"})
     */
    public function childrenProfile(Children $children): Response
    {
        return $this->render('people/children/profile.html.twig', [
                'profile' => $this->getDoctrine()->getRepository(Children::class)->find($children->getId()),
                'responsableList' => $this->getDoctrine()->getRepository(Responsable::class)->findAll()
            ]);
    }

    /**
     * @Route("/animateurs/{id}", name="animateur_profile", methods="GET", requirements={"id"="\d+"})
     */
    public function animateurProfile(Animateur $animateur): Response
    {
        return $this->render('people/animateur/profile.html.twig', [
                'profile' => $this->getDoctrine()->getRepository(Animateur::class)->find($animateur->getId())
            ]);
    }

    
    //**************************************** ADD ***********************************************/
    //********************************************************************************************/

    /**
     * @Route("/responsable/add", name="responsable_add")
     * @Route("/responsable/{id}/edit", name="responsable_edit", requirements={"id"="\d+"})
     */
    public function addResponsable(Responsable $entity = null, Request $request, EntityManagerInterface $manager): Response
    {
        $goBack = null; $goBackId = null;
        if ($request->query->get('goBack') != null) {
            $goBack = $request->query->get('goBack');
            $goBackId = $request->query->get('goBackId');
        }

        if (!$entity) {
            $entity = new Responsable();
        }
        elseif ($entity && $request->query->get('goBack') != null) {
            $goBack = $request->query->get('goBack');
            $goBackId = $entity->getId();
        }
        
        $form = $this->createForm(ResponsableType::class, $entity);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $manager->persist($entity);
            $manager->flush();

            $this->addFlash("success", "Données enregistrées");
            if ($goBack != null)
                return $this->redirectToRoute($goBack, ['id' => $goBackId]);    

            return $this->redirectToRoute('responsable_index');
        }

        return $this->render('people/responsable/form.html.twig', [
            'form' => $form->createView(),
            'goBack' => $goBack,
            'goBackId' => $goBackId,
            'editMode' => $entity->getId() !== null,
        ]);
    }

    /**
     * @Route("/enfant/{id}/responsable", name="children_addResponsable")
     */
    public function children_addResponsable(Children $entity, Request $request, EntityManagerInterface $manager)
    {
        if ($entity) {

            $idResponsable = $request->query->get('responsable');
            $obj = $this->getDoctrine()->getRepository(Responsable::class)->find($idResponsable);
            $entity->addResponsable($obj);
            $manager->flush();

            $this->addFlash("success", "Données enregistrées");
            return $this->redirectToRoute('children_profile', ['id' => $request->query->get('id')]);
        }
        else {
            $this->addFlash("error", "Une erreur est survenue...");
        } 
        return $this->redirectToRoute('children_index');
    }

    /**
     * @Route("/animateurs/add", name="animateur_add")
     * @Route("/animateurs/{id}/edit", name="animateur_edit", requirements={"id"="\d+"})
     */
    public function addAnimateur(Animateur $entity = null, Request $request, EntityManagerInterface $manager): Response
    {
        $goBack = null; $goBackId = null; $age = null;
        if ($request->query->get('goBack') != null) {
            $goBack = $request->query->get('goBack');
            $goBackId = $request->query->get('goBackId');
        }

        if (!$entity) {
            $entity = new Animateur();
        }
        elseif ($entity && $request->query->get('goBack') != null) {
            $goBack = $request->query->get('goBack');
            $goBackId = $entity->getId();
        }

        if ($entity)
            $age = $entity->getAge();
        
        $form = $this->createForm(AnimateurType::class, $entity);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $manager->persist($entity);
            $manager->flush();

            $this->addFlash("success", "Données enregistrées");
            if ($goBack != null)
                return $this->redirectToRoute($goBack, ['id' => $goBackId]);

            return $this->redirectToRoute('animateur_index');
        }

        return $this->render('people/animateur/form.html.twig', [
            'form' => $form->createView(),
            'goBack' => $goBack,
            'goBackId' => $goBackId,
            'editMode' => $entity->getId() !== null,
            'age' => $age //show age under Birthday input on editMode
        ]);
    }

    /**
     * @Route("/enfants/add", name="children_add")
     * @Route("/enfants/{id}/edit", name="children_edit", requirements={"id"="\d+"})
     */
    public function addChildren(Children $entity = null, Request $request, EntityManagerInterface $manager): Response
    {
        $goBack = null; $goBackId = null; $age = null;
        if ($request->query->get('goBack') != null) {
            $goBack = $request->query->get('goBack');
            $goBackId = $request->query->get('goBackId');
        }

        if (!$entity) {
            $entity = new Children();
        }
        elseif ($entity && $request->query->get('goBack') != null) {
            $goBack = $request->query->get('goBack');
            $goBackId = $entity->getId();
        }

        if ($entity)
            $age = $entity->getAge();
        
        $form = $this->createForm(ChildrenType::class, $entity);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $manager->persist($entity);
            $manager->flush();

            $this->addFlash("success", "Données enregistrées");
            if ($goBack != null)
                return $this->redirectToRoute($goBack, ['id' => $goBackId]);

            return $this->redirectToRoute('children_index');
        }

        return $this->render('people/children/form.html.twig', [
            'form' => $form->createView(),
            'goBack' => $goBack,
            'goBackId' => $goBackId,
            'editMode' => $entity->getId() !== null,
            'age' => $age //show age under Birthday input on editMode
        ]);
    }


}
