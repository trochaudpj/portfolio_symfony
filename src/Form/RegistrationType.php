<?php

namespace App\Form\Type;

use App\Entity\User;


use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class Registration extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options):void
    {
        $builder
            ->add('email',TextType::class)
            ->add('roles')
            ->add('password')
            ->add('is_active')
            ->add('security')
            ->add('activation_key')
            ->add('is_banned')
            ->add('is_dead')
            ->add('banned_raison')
            ->add('lastvisit',DateType::class)
            ->add('time_session',DateType::class)
            ->add('token')
            ->add('register_at')
            ->add('avatar')
            ->add('forced_avatar')
            ->add('view_vcard')
            ->add('view_qrcode')
            ->add('locale')
            ->add('timezone')
            ->add('pseudo')
            ->add('role')
            ->add('customer')
            ->add('pseudo')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
