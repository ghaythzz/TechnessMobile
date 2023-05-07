<?php

namespace App\Form;

use App\Entity\Pharmacie;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Validator\Constraints\LessThanOrEqual;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

class PharmacieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('Nom', TextType::class, [
            'label' => 'Nom',
            'required' => true,
            'constraints' => [
                    new Assert\Length([
                    'min' => 2,
                    'max' => 100,
                    'minMessage' => 'Le champ Nom doit contenir au moins 2 caractères.',
                    'maxMessage' => 'Le champ Nom ne peut pas contenir plus de 50 caractères.',
                ]),
            ],
        ])
        ->add('Adresse', TextType::class, [
            'label' => 'Adresse',
            'required' => true,
            'constraints' => [
                new Assert\Length(['max' => 255]),
            ],
        ])
        ->add('Tempo', DateTimeType::class, [
            'input' => 'datetime',
            'label' => 'Temps d ouverture',
            'widget' => 'single_text',
            'constraints' => [
                new Assert\NotBlank(),
                new Assert\Type(['type' => 'DateTimeInterface']),
            ],
        ])
        ->add('tempf', DateTimeType::class, [
            'input' => 'datetime',
            'label' => 'Temps de fermeture',
            'widget' => 'single_text',
            'constraints' => [
                new Assert\NotBlank(),
                new Assert\Type(['type' => 'DateTimeInterface']),
            ],
        ])        ;
    

    $builder->addEventListener(FormEvents::POST_SUBMIT, function (FormEvent $event) {
        $form = $event->getForm();
        $dateDebut = $form->get('Tempo')->getData();
        $dateFin = $form->get('tempf')->getData();
        if ($dateDebut > $dateFin) {
            $form->get('tempf')->addError(new \Symfony\Component\Form\FormError('La date de fin ne peut pas être antérieure à la date de début.'));
        }
    });
}
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Pharmacie::class,
        ]);
    }
}
