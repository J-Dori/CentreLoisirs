<?php

namespace App\Form;

use App\Entity\Rate;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

class RateType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', ChoiceType::class, [
                'placeholder' => '---',
                'choices' => $options['titles']
            ])
            ->add('child1', MoneyType::class, [
                'scale' => 2, 
                'currency' => false,
                'required' => true,
            ])
            ->add('child2', MoneyType::class, [
                'scale' => 2, 
                'currency' => false,
                'required' => false,
            ])
            ->add('child3', MoneyType::class, [
                'scale' => 2, 
                'currency' => false,
                'required' => false,
            ])
            ->add('child4', MoneyType::class, [
                'scale' => 2, 
                'currency' => false,
                'required' => false,
            ])
            ->add('child5', MoneyType::class, [
                'scale' => 2, 
                'currency' => false,
                'required' => false,
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
            'data_class' => Rate::class,
            'yearId' => '',
            'titles' => [],
        ]);
        $resolver->setAllowedTypes('yearId', 'string');
    }
}
