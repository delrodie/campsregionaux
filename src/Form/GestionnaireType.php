<?php

namespace App\Form;

use App\Entity\Gestionnaire;
use App\Entity\Sygesca\Region;
use App\Entity\User;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GestionnaireType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class,[
                'attr'=>['class'=>"form-control", 'placeholder'=>'Nom', 'autocomplete'=>'off']
            ])
            ->add('prenom', TextType::class,[
                'attr'=>['class'=>"form-control", 'placeholder'=>'Prenom', "autocomplete'=>'off"]
            ])
            ->add('tel', TextType::class,[
                'attr'=>['class'=>"form-control", 'placeholder'=>'Numero de telephone', 'autocomplete'=>'off'],
                'required'=>'false'
            ])
            ->add('region', EntityType::class,[
                'attr'=>['class'=>'form-control'],
                'class'=>Region::class,
                'query_builder' => function(EntityRepository $er){
                    return $er->liste();
                },
                'choice_label'=>'nom',
                'label'=>'Region'
            ])
            ->add('user', EntityType::class,[
                'attr'=>['class'=>'form-control'],
                'class'=>User::class,
                'query_builder' => function(EntityRepository $er){
                    return $er->liste();
                },
                'choice_label'=>'username',
                'label'=>'Nom utilisateur'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Gestionnaire::class,
        ]);
    }
}
