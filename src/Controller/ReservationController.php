<?php

namespace App\Controller;

use App\Entity\Reservation;
use App\Form\ReservationType;
use App\Repository\ReservationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/reservation')]
class ReservationController extends AbstractController
{
    #[Route('/', name: 'app_reservation_index', methods: ['GET'])]
    public function index(ReservationRepository $reservationRepository): Response
    {
        return $this->render('reservation/index.html.twig', [
            'reservations' => $reservationRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_reservation_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ReservationRepository $reservationRepository): Response
    {
        $reservation = new Reservation();
        $reservation->setDateR(new \DateTime()); 
        $form = $this->createForm(ReservationType::class, $reservation);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $reservedPlaces = $form->get('reserved_places')->getData();
            $terrain = $reservation->getTerrain();
            $date = $reservation->getDateR();
            $heure = $reservation->getHeureR();
    
            // Vérifier si le terrain est disponible pour la date et l'heure choisies
            $existingReservation = $reservationRepository->findExistingReservation($terrain, $date, $heure);
            if ($existingReservation) {
                // Si une réservation existe déjà pour le terrain, la date et l'heure choisis,
                // afficher un message d'erreur et retourner à la page de réservation
                $this->addFlash('error', 'Ce terrain est déjà réservé pour cette date et heure.');
                return $this->redirectToRoute('app_reservation_new');
            }
    
            if ($terrain->getNbPlaces() >= $reservedPlaces) {
                $reservationRepository->save($reservation, true);
                return $this->redirectToRoute('app_front_office_home', [], Response::HTTP_SEE_OTHER);
            } else {
                // Si le nombre de places n'est pas disponible, afficher un message d'erreur
                $this->addFlash('error', 'Le nombre de places demandé n\'est pas disponible.');
            }
        }
    
        return $this->renderForm('reservation/new.html.twig', [
            'reservation' => $reservation,
            'form' => $form,
        ]);
    }
    

    #[Route('/{id}', name: 'app_reservation_show', methods: ['GET'])]
    public function show(Reservation $reservation): Response
    {
        return $this->render('reservation/show.html.twig', [
            'reservation' => $reservation,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_reservation_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Reservation $reservation, ReservationRepository $reservationRepository): Response
    {
        $form = $this->createForm(ReservationType::class, $reservation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $reservationRepository->save($reservation, true);

            return $this->redirectToRoute('app_reservation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('reservation/edit.html.twig', [
            'reservation' => $reservation,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_reservation_delete', methods: ['POST'])]
    public function delete(Request $request, Reservation $reservation, ReservationRepository $reservationRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$reservation->getId(), $request->request->get('_token'))) {
            $reservationRepository->remove($reservation, true);
        }

        return $this->redirectToRoute('app_reservation_index', [], Response::HTTP_SEE_OTHER);
    }
}
