<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RequestStack;
use Psr\Log\LoggerInterface;
use App\Repository\TicketRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Ticket;
class TicketController extends AbstractController
{

   /**
   * @Route("/ticket", name="index")
   */
   public function index(TicketRepository $TicketRepository,ManagerRegistry $doctrine) :Response
   {
     $repository = $doctrine->getRepository(Ticket::class);
     $tickets = $repository->findAll();
     return $this->render('ticket/index.html.twig', [
         'tickets' => $tickets,
     ]);
   }
   /**
   * @Route("/ticket/{id}", name="show")
   */
   public function show(Ticket $ticket) :Response
   {     return $this->render('ticket/show.html.twig', [
         'ticket' => $ticket,
     ]);
   }

}
