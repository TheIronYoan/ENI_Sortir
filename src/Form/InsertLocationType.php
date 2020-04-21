<?php

namespace App\Form;

use App\Entity\City;
use App\Entity\Location;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InsertLocationType extends AbstractType
{

    private $cities;

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $this->cities = $options['cities'];

        $builder
            ->add('name')
            ->add('street')
            ->add('addrComplement')
            ->add('latitude')
            ->add('longitude')
            ->add('city', EntityType::class, [
                'class' => City::class,
                'choice_label' => 'name',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Location::class,
            'cities' => false,
        ]);

        $resolver->setAllowedTypes('cities', 'array');
    }
}
