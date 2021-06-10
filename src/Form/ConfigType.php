<?php

namespace App\Form;

use App\Entity\Config;
use App\Entity\Sygesca\Region;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ConfigType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('apikey', TextType::class,[
                'attr' =>['class'=>"form-control", 'placeholder'=>"La clé de l'API", "autocomplete"=>"off"],
                'label'=>"Apikey"
            ])
            ->add('siteId', TextType::class,[
                'attr' =>['class'=>"form-control", 'placeholder'=>"L'id du Site", "autocomplete"=>"off"],
                'label'=>"Site ID"
            ])
            ->add('couleurRGB', TextType::class,[
                'attr' =>['class'=>"form-control", 'placeholder'=>"La couleur RGB", "autocomplete"=>"off"],
                'label'=>"RGB"
            ])
            ->add('couleurTheme', TextType::class,[
                'attr' =>['class'=>"form-control", 'placeholder'=>"La couleur theme", "autocomplete"=>"off"],
                'label'=>"Theme"
            ])
            ->add('bg', TextType::class,[
                'attr' =>['class'=>"form-control", 'placeholder'=>"L'image background", "autocomplete"=>"off"],
                'label'=>"Image"
            ])
            ->add('logoRegion', TextType::class,[
                'attr' =>['class'=>"form-control", 'placeholder'=>"Le logo de la region", "autocomplete"=>"off"],
                'label'=>"Logo"
            ])
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
            'data_class' => Config::class,
        ]);
    }
}
