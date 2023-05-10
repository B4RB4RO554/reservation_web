<?php

namespace App\Controller\FrontOffice;

use App\Repository\ReservationRepository;
use App\Repository\TerrainRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeFrontOfficeController extends AbstractController
{
    #[Route('/', name: 'app_front_office_home')]
    public function home(): Response
    {
        return $this->render('front_office/front_terrain/index.html.twig', [
            'controller_name' => 'HomeFronOfficeController',
        ]);
    }
    #[Route('/about', name: 'app_front_office_about')]
    public function about(): Response
    {
        return $this->render('front_office/about.html.twig', [
            'controller_name' => 'HomeFronOfficeController',
        ]);
    }



 
}
