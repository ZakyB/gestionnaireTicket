<?php
namespace App\Controller;
use App\Entity\Status;
use App\Form\Type\StatusType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\StatusRepository;


class StatusController extends AbstractController
{
  /**
  * @Route("/status/create",name="Status_create")
  */
  public function newStatus(Request $request,ManagerRegistry $doctrine): Response
  {
      // just set up a fresh $task object (remove the example data)
      $status = new Status();

      $form = $this->createForm(StatusType::class, $status);

      $form->handleRequest($request);
      if ($form->isSubmitted() && $form->isValid()) {
        $entityManager = $doctrine->getManager();
          // $form->getData() holds the submitted values
          // but, the original `$task` variable has also been updated
          $status = $form->getData();
          $entityManager->persist($status);
          $entityManager->flush();

          return $this->redirectToRoute('Status_create');
      }

      return $this->renderForm('status/new.html.twig', [
          'form' => $form,
      ]);
  }
  /**
  * @Route("/status/show",name="Status_show")
  */
  public function showStatus(StatusRepository $StatusRepository,ManagerRegistry $doctrine): Response
  {
    $repository = $doctrine->getRepository(Status::class);
    $status = $repository->findAll();
    return $this->renderForm('status/show.html.twig',[
      'status' => $status,
    ]);
  }
  /**
 * @Route("/status/edit/{id}/{name}")
 */
 public function Update(ManagerRegistry $doctrine, int $id,string $name): Response
 {
   $entityManager = $doctrine->getManager();
   $status = $entityManager->getRepository(Status::class)->find($id);


    if (!$status)
    {
      throw $this->createNotFoundException(
        'No product found for id '.$id
      );
    }
    $status->setName($name);
    $entityManager->flush();
    return $this->redirectToRoute('Status_show');
 }
 /**
 * @Route("/status/delete/{id}")
 */
public function Delete(ManagerRegistry $doctrine,int $id): Response
{
  /*$entityManager = $doctrine->getManager();
  $status = $entityManager->getRepository(Status::class)->find($id);
  $entityManager->remove($status);
  $entityManager->flush();
  return $this->redirectToRoute('Status_show');*/
  $form = $this->createForm(StatusType::class, $status);
}
}
?>
