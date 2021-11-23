<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class YearController extends AbstractController
{
    /**
     * @Route("/year", name="year")
     */
    public function index(): Response
    {
        return $this->render('year/index.html.twig', [
            'controller_name' => 'YearController',
        ]);
    }
}
