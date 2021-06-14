<?php

namespace App\Form;

use App\Entity\Sygesca\Scout;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchCivilType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            //->add('matricule')
            ->add('nom', TextType::class,[
                'attr'=>['class'=>'form-control', 'placeholder'=>"Nom", 'autocomplete'=>"off"],
                'label'=>"Nom de famille"
            ])
            ->add('prenoms', TextType::class,[
                'attr'=>['class'=>'form-control', 'placeholder'=>"Prénoms", 'autocomplete'=>"off"],
                'label'=>"Prenoms"
            ])
            ->add('datenaiss', TextType::class,[
                'attr'=>['class'=>"form-control datepicker", 'autocomplete'=>'off', 'placeholder'=>"Date de naissance"],
                'label' => "Date de naissance"
            ])
            ->add('lieunaiss', TextType::class,[
                'attr'=>['class'=>'form-control', 'placeholder'=>"Lieu de naissance", 'autocomplete'=>"off"],
                'label'=>"Lieu de naissance"
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Scout::class,
        ]);
    }
}
