<?php

namespace App\Form;

use App\Entity\Event;
use Symfony\Component\Form\AbstractType;
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
            ->add('duration', NumberType::class,['label'=> 'Durée' ])
            ->add('signInLimit',DateTimeType::class,['label'=> 'Date limite d\'inscription' ])
            ->add('maxUsers', NumberType::class,['label'=> 'Nombre maximum de participants' ])
            ->add('description', TextType::class)
        ;
    }
}
