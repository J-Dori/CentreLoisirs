<?php

namespace App\Form;

use App\Entity\Week;

use App\Entity\Year;
use App\Entity\AgeGroup;
use App\Entity\Children;
use App\Entity\InscriptionDetail;
use App\Repository\WeekRepository;
use App\Repository\YearRepository;
use App\Repository\AgeGroupRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;



class InscriptionDetailType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('children', EntityType::class, [
                'placeholder' => '---',
                'class' => Children::class,
                'label' => 'Enfant',
                'choice_label' => function ($child) {
                    return $child->getNameAndAge();
                }
            ])
            ->add('week', EntityType::class, [
                'placeholder' => '---',
                'class' => Week::class,
                'query_builder' => function(WeekRepository $repo) use ($options) {
                    return $repo->createQueryBuilder('w')
                                ->andWhere('w.year = :val')
                                ->setParameter('val', $options['yearId']);
                },
                'label' => 'Semaine '
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
            ->add('withMeal', ChoiceType::class, [
                    'choices'  => [
                        'Oui' => true,
                        'Non' => false,
                    ],
                    'expanded' => false,
                    'multiple' => false,
                    'required' => true,
                    'label' => 'Avec Repas ',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => InscriptionDetail::class,
            'yearId' => 0,
        ]);
    }
}
