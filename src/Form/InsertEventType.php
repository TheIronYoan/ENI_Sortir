<?php

namespace App\Form;

use App\Entity\Event;
use App\Entity\EventState;
use App\Entity\Location;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\GreaterThan;

class InsertEventType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class)
            ->add('start',DateTimeType::class,['label'=> 'Débute le' ])
            ->add('duration', IntegerType::class,['label'=> 'Durée' ])
            ->add('signInLimit',DateTimeType::class,['label'=> 'Date limite d\'inscription' ])
            ->add('maxUsers', IntegerType::class,['label'=> 'Nombre maximum de participants' ])
            ->add('description', TextType::class)
            ->add('state', EntityType::class,[
                'class' => EventState::class,
                'choice_label' => 'label',
            ])
            ->add('location', EntityType::class, [
                'class' => Location::class,
                'choice_label' => 'name',
            ])
        ;

    }
}
