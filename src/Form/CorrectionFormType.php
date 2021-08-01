<?php

namespace App\Form;

use App\Entity\Paiement;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CorrectionFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class,['attr'=>['class'=>"form-control", 'readonly'=>"true"], 'required'=>false])
            ->add('prenoms', TextType::class,['attr'=>['class'=>'form-control', 'readonly'=>"true"], 'required'=>false])
            //->add('sexe')
            ->add('dateNaissance', TextType::class,['attr'=>['class'=>"form-control", 'readonly'=>"true"], 'required'=>false])
            ->add('lieuNaissance', TextType::class,['attr'=>['class'=>"form-control", 'readonly'=>"true"], 'required'=>false])
            //->add('carte')
            ->add('matricule', TextType::class,['attr'=>['class'=>"form-control", 'readonly'=>true], 'required'=>false])
            //->add('fonction')
            //->add('contact')
            //->add('urgence')
            //->add('contactUrgence')
            ->add('idTransaction', TextType::class,['attr'=>['class'=>"form-control"]])
            //->add('statusPaiement')
            //->add('createdAt')
            //->add('slug')
            //->add('montant')
            //->add('statut')
            //->add('updatedAt')
            //->add('paieTelephone')
            //->add('paieDate')
            //->add('paieTime')
            //->add('groupe')
            //->add('activite')
            //->add('type')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Paiement::class,
        ]);
    }
}
