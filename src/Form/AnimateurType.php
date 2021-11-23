<?php

namespace App\Form;

use App\Entity\Animateur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class AnimateurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', ChoiceType::class, [
                'choices'  => [
                    '---' => null,
                    'Mme' => "Mme",
                    'Mr' => "Mr",
                ],
            ])
            ->add('lname', TextType::class)
            ->add('fname', TextType::class)
            ->add('birthday', DateType::class,[
                'label' => 'Date Naissance',
                'widget' => 'single_text'
            ])
            ->add('birthCity', TextType::class, ['required' => false])
            ->add('address', TextType::class)
            ->add('cp', TextType::class)
            ->add('city', TextType::class)
            ->add('email', EmailType::class)
            ->add('phoneMob', TextType::class)
            ->add('phoneHome', TextType::class, ['required' => false])
            ->add('numSS', TextType::class, ['required' => false])
            ->add('notes', TextareaType::class, ['required' => false])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Animateur::class,
        ]);
    }
}
