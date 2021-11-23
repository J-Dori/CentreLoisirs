<?php

namespace App\Form;

use App\Entity\AgeGroup;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

class AgeGroupType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('ageGroup', ChoiceType::class, [
                'placeholder' => '---',
                'choices' => $options['titles']
            ])
            ->add('year', NumberType::class, [
                'data' => $options['yearId'],
                'mapped' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => AgeGroup::class,
            'yearId' => '',
            'titles' => [],
        ]);
        $resolver->setAllowedTypes('yearId', 'string');
    }
}
