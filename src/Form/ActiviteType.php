<?php

namespace App\Form;

use App\Entity\Activite;
use App\Entity\Sygesca\Region;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class ActiviteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class,[
                'attr'=>['class' => 'form-control', 'placeholder' => "Denommination de l'activité", 'autocomplete' => 'off'],
                'label'=> "Nom"
            ])
            ->add('montant', IntegerType::class,[
                'attr'=>['class' => 'form-control', 'placeholder' => 'Montant de la participation', 'autocomplete' => 'off'],
                'label' => "Montant"
            ])
            ->add('lieu', TextType::class,[
                'attr'=>['class' => 'form-control', 'placeholder' => 'Lieu de la participation', 'autocomplete' => 'off'],
                'label' => 'Le lieu '
            ])
            ->add('debut', TextType::class,[
                'attr'=>['class' => 'form-control datepicker', 'placeholder' => 'Date début', 'autocomplete' => 'off'],
                'label' => 'Debut période'
            ])
            ->add('fin', TextType::class,[
                'attr'=>['class' => 'form-control datepicker', 'placeholder'=>'Date fin', 'autocomplete'=>'off'],
                'label' => 'Fin periode'
            ])
            ->add('description', TextareaType::class,[
                'attr'=>['class' => 'form-control', 'rows'=>5, 'placeholder'=>"Description"],
                'label' => "Description"
            ])
            ->add('logo', FileType::class,[
                'attr'=>['class'=>"dropify", 'data-preview' => ".preview"],
                'label' => "Télécharger la photo",
                'mapped' => false,
                'multiple' => false,
                'constraints' => [
                    new File([
                        'maxSize' => "1000000k",
                        'mimeTypes' =>[
                            'image/png',
                            'image/jpeg',
                            'image/jpg',
                            'image/gif',
                            'image/webp',
                        ],
                        'mimeTypesMessage' => "Votre fichier doit être de type image"
                    ])
                ],
                'required' => false
            ])
            //->add('createdAt')
            ->add('region', EntityType::class,[
                'attr'=>['class' => 'form-control'],
                'class' => Region::class,
                'query_builder' => function(EntityRepository $er){
                    return $er->liste();
                },
                'choice_label' => 'nom',
                'label' => 'Nom'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Activite::class,
        ]);
    }
}
