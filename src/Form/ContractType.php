<?php

namespace App\Form;

use App\Entity\AgeGroup;
use App\Entity\Animateur;
use App\Entity\AnimateurContract;
use App\Repository\AgeGroupRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

class ContractType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('animateur', EntityType::class, [
                'placeholder' => '---',
                'class' => Animateur::class,
            ])
            ->add('typeContract', ChoiceType::class, [
                'placeholder' => '---',
                'choices' => $options['titles']
            ])
            ->add('ageGroup', EntityType::class, [
                'placeholder' => '---',
                'class' => AgeGroup::class,
                'query_builder' => function(AgeGroupRepository $repo) use ($options) {
                    return $repo->createQueryBuilder('ag')
                                ->andWhere('ag.year = :val')
                                ->setParameter('val', $options['yearId']);
                },
                'label' => 'Groupe d\'âge'
            ])
            ->add('salary', MoneyType::class, [
                'scale' => 2, 
                'currency' => false,
                'required' => true,
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
            'data_class' => AnimateurContract::class,
            'yearId' => '',
            'titles' => [],
        ]);
    }
}
