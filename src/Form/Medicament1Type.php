<?php

namespace App\Form;

use App\Entity\Medicament;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Form\Extension\Core\Type\FileType;





class Medicament1Type extends AbstractType
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
            
            ->add('Type', ChoiceType::class, [
                'choices'  => [
                    'Choisir Type' => '',
                    'Liquide' => 'Liquide',
                    'Comprimé' => 'Comprimé',
                    'Sachét' => 'Sachét',
                ],
            
            ])
            ->add('Nb_dose', IntegerType::class, [
                'label' => 'Nombres des doses',
                'required' => true,
                'constraints' => [
                    new Assert\Range([
                        'min' => 1,
                        'max' => 6,
                        'minMessage' => 'Le nombre des doses doit être supérieur ou égal à 1.',
                        'maxMessage' => 'Le nombre des doses doit être inférieur ou égal à 6',
                    ]),
                ],
            ])
            ->add('Prix', NumberType::class, [
                'label' => 'Prix',
                'required' => true,
                'scale' => 2,
                'constraints' => [
                    new Assert\Range([
                        'min' => 100,
                        'max' => 100000000,
                        'minMessage' => 'Le prix doit être supérieur ou égal à 100 Millimes.',
                        'maxMessage' => 'Le prix doit être inférieur ou égal à 1000 Dinars.',
                    ]),
                ],
            ])
            ->add('Stock')
            ->add('id_pharmacie')
            ->add('image', FileType::class, [
                'label' => 'image (Image)',

                // unmapped means that this field is not associated to any entity property
                'mapped' => false,

                // make it optional so you don't have to re-upload the PDF file
                // every time you edit the Product details
                'required' => false,

                // unmapped fields can't define their validation using annotations
                // in the associated entity, so you can use the PHP constraint classes
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'image/pdf',
                            'image/jpeg',
                            'image/png',
                            'image/jpg',
                        ],
                        'mimeTypesMessage' => 'Please upload a valid  document',
                    ])
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Medicament::class,
        ]);
    }
}
