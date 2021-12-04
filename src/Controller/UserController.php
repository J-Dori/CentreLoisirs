<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserEditType;
use App\Form\RegistrationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

/**
* @Route("/utilisateurs")
*/

class UserController extends AbstractController
{

    /**
     * @Route("/{id}", name="user_profile", methods="GET", requirements={"id"="\d+"})
     */
    public function userProfile(User $user): Response
    {
        return $this->render('people/user/profile.html.twig', [
                'profile' => $this->getDoctrine()->getRepository(User::class)->find($user->getId())
            ]);
    }

    /**
     * @Route("/add", name="app_register")
     */
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasherInterface): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode password
            $user->setPassword(
            $userPasswordHasherInterface->hashPassword(
                    $user,
                    $form->get('password')->getData()
                )
            );

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            // do anything else you need here, like send an email

            return $this->redirectToRoute('user_index');
        }

        return $this->render('people/user/formAdd.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="user_edit", requirements={"id"="\d+"})
     */
    public function editUser(User $entity = null, Request $request, EntityManagerInterface $manager): Response
    {
        if (!$entity) {
            $entity = new User();
        }
        
        //current User logged in - if ADMIN it will display ROLES
        $isAdmin = $this->isGranted('ROLE_ADMIN'); 

        $form = $this->createForm(UserEditType::class, $entity, ['isAdmin' => $isAdmin]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $manager->persist($entity);
            $manager->flush();

            $this->addFlash("success", "Données enregistrées");
            return $this->redirectToRoute('user_index');
        }

        return $this->render('people/user/formEdit.html.twig', [
            'form' => $form->createView(),
            'editMode' => $entity->getId() !== null
        ]);
    }
}
