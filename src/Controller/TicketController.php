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
use Symfony\Component\HttpFoundation\Request;
use App\Form\Type\TicketType;

class TicketController extends AbstractController
{
   /**
   * @Route("/", name="index")
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
   * @Route("/ticket/create" ,name="ticket_create")
   */
   public function newTicket(Request $request, ManagerRegistry $doctrine): Response
   {
     $ticket = new Ticket();

     $form = $this->createForm(TicketType::class, $ticket);
     $form->handleRequest($request);
     if ($form->isSubmitted() && $form->isValid())
     {
       $entityManager = $doctrine->getManager();
       $ticket= $form->getData();
       $entityManager->persist($ticket);
       $entityManager->flush();

       return $this->redirectToRoute('index');
     }

     return $this->renderForm('ticket/new.html.twig', [
         'form' => $form,
     ]);
   }

   /**
   * @Route("/ticket/delete/{id}" ,name="ticket_delete")
   */
   public function delete(ManagerRegistry $doctrine, int $id): Response
   {
     $entityManager = $doctrine->getManager();
     $Ticket = $entityManager->getRepository(Ticket::class)->find($id);
     $entityManager->remove($Ticket);
     $entityManager->flush();
     return $this->redirectToRoute('index');
   }


   /**
   * @Route("/ticket/update/{id}", name="ticket_update")
   */
   public function update(Request $request,ManagerRegistry $doctrine,Ticket $ticket): Response
   {
     $form = $this->createForm(TicketType::class,$ticket);
     $form->handleRequest($request);
     if ($form->isSubmitted() && $form->isValid()){
       $entityManager = $doctrine->getManager();
       $ticket = $form->getData();
       $entityManager->persist($ticket);
       $entityManager->flush();
       return $this->redirectToRoute('index');
     }
     return $this->renderForm('ticket/new.html.twig',[
       'form' => $form,
     ]);
   }
   /**
   * @Route("/ticket/{id}", name="ticket_show")
   */
   public function show(Ticket $ticket) :Response
   {
      return $this->render('ticket/show.html.twig', [
         'ticket' => $ticket,
     ]);
   }

}
