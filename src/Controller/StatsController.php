<?php

namespace App\Controller;

use App\Repository\ReservationRepository;
use Dompdf\Dompdf;
use Dompdf\Options;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StatsController extends AbstractController
{
    #[Route('/stats', name: 'app_stats')]
   public function statistiques1(ReservationRepository $footRepo){
        // On va chercher toutes les menus
        $reservation = $footRepo->findAll();

//Data Category
        $puma = $footRepo->createQueryBuilder('a')
            ->select('count(a.id)')
            ->Where('a.type= :type')
            ->setParameter('type',"Complet ")
            ->getQuery()
            ->getSingleScalarResult();

        $adidas = $footRepo->createQueryBuilder('a')
            ->select('count(a.id)')
            ->Where('a.type= :type')
            ->setParameter('type',"Par Place")
            ->getQuery()
            ->getSingleScalarResult();




        return $this->render('stats/index.html.twig', [
            'liv' => $puma,
            'cl' => $adidas,



        ]);

    }
    #[Route('/pdf', name: 'app_pdf', methods:['GET','Post'])]
    
        public function datapdf(ReservationRepository $produitRepository):Response
        {       $data=$produitRepository->findAll();
             
                $pdfOptions = new Options();
                $pdfOptions->set('defaultFront','Arial');
                $pdfOptions->setIsRemoteEnabled(true);
    
    // On instancie Dompdf
    
                $dompdf = new Dompdf($pdfOptions); $context = stream_context_create([
    
                'ssl' => [
    
                    'verify_peer' => FALSE,
                     'verify_peer_name' => FALSE,
                     'allow_self_signed' => TRUE
    
                ]
                ]);
    
                $dompdf->setHttpContext($context);
                $html = $this->renderView('stats/pdf.html.twig',[
                    'produits'=>$data,
                ]);
                // Load HTML to Dompdf
             $dompdf->loadHtml($html);
     
             // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
             $dompdf->setPaper('A4', 'portrait');
     
             // Render the HTML as PDF
             $dompdf->render();
    
            $fichier = 'RES.pdf';
             $dompdf->stream($fichier, [
                "Attachment" => true
             ]);
    
             return new Response();
                
    
            
            }


}
