<?php

namespace App\Form;

use App\Entity\Sygesca\Scout;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SearchType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchMatriculeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('matricule', SearchType::class,[
                'attr'=>['class' => 'form-control', 'placeholder'=>'Entrez votre matricule', 'autocomplete'=>"off", 'aria-describedby'=>'button-addon2'],
                'required'=>true,
                'label'=>'Recherche'
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
