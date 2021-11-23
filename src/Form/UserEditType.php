<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;


class UserEditType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class)
            ->add('lname', TextType::class)
            ->add('fname', TextType::class)
            ->add('phoneMob', TextType::class)
        ;

        if ($options['isAdmin']) {
            $builder
            ->add('roles', ChoiceType::class, [
                    'choices'  => [
                        'Administrateur' => 'ROLE_ADMIN',
                        'Utilisateur' => 'ROLE_USER'
                    ],
                    'placeholder' => '---',
                    'expanded' => true,
                    'multiple' => false,
                    'required' => true,
            ]);

            $builder->get('roles')
                ->addModelTransformer(new CallbackTransformer(
                    function ($rolesArray) {
                        // transform the array to a string
                        return count($rolesArray) ? $rolesArray[0] : null;

                    },
                    function ($rolesString) {
                        // transform the string back to an array
                        return [$rolesString];
                    }
            ));
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'isAdmin' => false,
        ]);
        $resolver->setAllowedTypes('isAdmin', 'bool');
    }
}
