<?php

namespace App\Form;

use App\Entity\City;
use App\Entity\EventFilter;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SearchType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EventFilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('searchZone',SearchType::class,[
                'required'=>false,
                'label'=>'Description',
        ])
            ->add('city', EntityType::class, [
                'class' => City::class,
                'choice_label' => 'name',
                'label' => 'Ville'
            ])
            ->add('dateBegin', DateTimeType::class,['label'=> 'Débute entre le :' ,'required'   => false])
            ->add('dateEnd',DateTimeType::class,['label'=> 'et le :' ,'required'   => false])
            ->add('organizedEvent',CheckboxType::class, ['label' => 'Sorties que j\'organise', 'required'   => false,'data'=>true ] )
            ->add('joinedEvent',CheckboxType::class, ['label' => 'Sorties auxquels je participe', 'required'   => false,'data'=>true ] )
            ->add('joinableEvent',CheckboxType::class, ['label' => 'Sorties auxquels je ne participe pas', 'required'   => false,'data'=>true ] )
            ->add('pastEvent',CheckboxType::class, ['label' => 'Sorties terminés', 'required'   => false, ] )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => EventFilter::class,
            'method'=>'get',
            'csrf_protection'=>false
        ]);
    }
}
