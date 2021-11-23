<?php

namespace App\Form;

use App\Entity\Children;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ChildrenType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('sex', ChoiceType::class, [
                'choices'  => [
                    'Fille' => "Fille",
                    'Garçon' => "Garçon",
                    'Autre' => "Autre",
                ],
                "placeholder" => "---"
            ])
            ->add('lname', TextType::class)
            ->add('fname', TextType::class)
            ->add('birthday', DateType::class,[
                'label' => 'Date Naissance',
                'widget' => 'single_text'
            ])
            ->add('medicalObs', TextareaType::class, ['required' => false])
            ->add('allergyObs', TextareaType::class, ['required' => false])
            ->add('foodObs', TextareaType::class, ['required' => false])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Children::class,
        ]);
    }
}
