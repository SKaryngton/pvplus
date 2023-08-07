<?php

namespace App\Controller;

use App\Service\apiService;
use Exception;
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

    #[Route('/home', name: 'app_home')]
    public function home(apiService $apiService): Response
    {
        return $this->render('homepage/index.html.twig');
    }

    /**
     * @throws Exception
     */
    #[Route('/load_data', name: 'app_load_data')]
    public function load(apiService $apiService): Response
    {
        $apiService->loadData();
        return $this->render('homepage/index.html.twig');
    }
}
