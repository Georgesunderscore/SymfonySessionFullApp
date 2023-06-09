<?php

namespace App\Form;

use App\Entity\Stagiaire;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class StagiaireType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom',  TextType::class, ['attr' => ['class' => 'form-control']])
            ->add('prenom',  TextType::class, ['attr' => ['class' => 'form-control']])
            ->add('email',  TextType::class, ['attr' => ['class' => 'email form-control']])
            ->add('submit', SubmitType::class, ['attr' => ['class' => 'btn btn-success']    ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Stagiaire::class,
        ]);
    }
}
