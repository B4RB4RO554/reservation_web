<?php

namespace App\Controller;

use App\Entity\Terrain;
use App\Repository\ReservationRepository;
use App\Repository\TerrainRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
class FrontTerrainController extends AbstractController
{
    #[Route('/front/terrain', name: 'app_front_terrain')]
    public function index(TerrainRepository $terrainRepository ,ReservationRepository $reservationRepository ): Response
    {
        $terrain=$terrainRepository->findAll();
        $reservation= $reservationRepository->findAll();
        return $this->render('front_office/front_terrain/terrain.html.twig', [
            'terrain' => 'terrainController',
            'terrains' => $terrain,
            'reservations' =>$reservation,
        ]);
        /*return $this->render('front_terrain/index.html.twig', [
            'controller_name' => 'FrontTerrainController',
        ]);*/
    }
      /**
     * @Route("/{id}/rate", name="app_terrain_rate", methods={"GET", "POST"})
     */
    public function rate(Terrain $activite, Request $request, EntityManagerInterface $entityManager): Response
    {

        $form = $this->createFormBuilder($activite)->add('rating',HiddenType::class)->getForm();
        $form->handleRequest($request);
        $rating = $form->get('rating')->getData();

        if ($form->isSubmitted()) {
            $activite->setRating($rating);
            $entityManager->flush();

            return $this->redirectToRoute('app_terrain_rate', ['id'=> $activite->getId()], Response::HTTP_SEE_OTHER);
        }
        return $this->render('terrain/rating.html.twig', ['activite' => $activite, 'form' => $form->createView(),]);
    }
}
