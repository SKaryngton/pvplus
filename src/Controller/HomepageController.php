<?php

namespace App\Controller;

use App\Service\apiService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomepageController extends AbstractController
{
    #[Route('/', name: 'app_homepage')]
    public function index(apiService $apiService): Response
    {
        $apiService->connect();
        return $this->render('homepage/index.html.twig');
    }
}
