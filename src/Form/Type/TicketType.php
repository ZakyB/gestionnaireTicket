<?php
namespace App\Form\Type;

use App\Entity\Status;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class TicketType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        /*$repository = $doctrine->getRepository(Status::class);
        $status = $repository->findAll();*/
        $builder
            ->add('titre', TextType::class)
            ->add('date', DateType::class)
            ->add('status', EntityType::class, [
              'class' => Status::class,
              'choice_label' => 'name',
            ])
            ->add('message', TextType::class)
            ->add('save', SubmitType::class)
        ;
    }
}

 ?>
