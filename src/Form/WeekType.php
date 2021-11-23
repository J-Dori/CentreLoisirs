<?php

namespace App\Form;

use App\Entity\Week;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

class WeekType extends AbstractType
{
    

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('weekNum', NumberType::class)
            ->add('theme', TextType::class)
            ->add('dateStart', DateType::class,[
                'label' => 'Date Naissance',
                'widget' => 'single_text'
            ])
            ->add('dateEnd', DateType::class,[
                'label' => 'Date Naissance',
                'widget' => 'single_text'
            ])
            ->add('weekType', ChoiceType::class, [
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
            'data_class' => Week::class,
            'yearId' => '',
            'titles' => [],
        ]);
        $resolver->setAllowedTypes('yearId', 'string');
    }
}
