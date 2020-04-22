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
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\GreaterThan;

class InsertEventType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class,['label'=> 'Nom' ])
            ->add('start',DateTimeType::class,['label'=> 'Débute le' ])
            ->add('duration', IntegerType::class,['label'=> 'Durée' ])
            ->add('signInLimit',DateTimeType::class,['label'=> 'Date limite d\'inscription' ])
            ->add('maxUsers', IntegerType::class,['label'=> 'Nombre maximum de participants' ])
            ->add('description', TextType::class)
            ->add('state', ChoiceType::class,[
                'choices' => ['Créée'=>new EventState(1,'Créée'),
                    'Ouverte'=>new EventState(2,'Ouverte'),
                    'Cloturée'=>new EventState(1,'Cloturée'),
                    'Annulée'=>new EventState(1,'Annulée'),
                ],
            ])
            ->add('location', EntityType::class, [
                'class' => Location::class,
                'choice_label' => 'name',
            ])
        ;
    }
}
