<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserInfoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $message="";
        $builder
            ->add('name',null,['label'=> 'Nom' ])
            ->add('firstname',null,['label'=> 'Prenom' ])
            ->add('username',null,[
                    'label'    => 'Pseudo',
                    'attr' => ['class' => 'tinymce','pattern'=>'[a-Z]*','title'=>'Rentrer un champ ne contenant que .....']
                ]
            )
            ->add('email',EmailType::class)
            ->add('phone',null,['label'    => 'Téléphone'])
            ->add('illustration', FileType::class, [
                'label' => 'Photo de profil',
                'mapped' => false,
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
