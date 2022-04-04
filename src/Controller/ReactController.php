<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ReactController extends AbstractController
{
    #[Route('/{react}', requirements: ["react" => "^((?!api).)*$"])]
    public function index(): Response
    {
        return $this->render('react/index.html.twig');
    }
}
