<?php

namespace App\Form;

use App\Entity\Rate;
use App\Entity\Inscription;
use App\Entity\Responsable;
use App\Repository\RateRepository;
use App\Form\InscriptionDetailType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class InscriptionEditType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('numInsc', NumberType::class, [
                'disabled' => true
            ])
            ->add('notes', TextareaType::class, [
                'required' => false
            ])
            ->add('rate', EntityType::class, [
                'class' => Rate::class,
                'query_builder' => function(RateRepository $repo) use ($options) {
                    return $repo->createQueryBuilder('r')
                                ->andWhere('r.year = :val')
                                ->setParameter('val', $options['yearId']);
                },
                'choice_label' => 'title',
                'choice_value' => 'id',
            ])
            ->add('responsable', EntityType::class, [
                'class' => Responsable::class,
            ])
            ->add('totalWeek', MoneyType::class, [
                'scale' => 2, 
                'currency' => false,
                'required' => false,
            ])
            ->add('qttMeal', NumberType::class, [
                'required' => false,
                'attr' => [
                    'min' => 0,
                    'max' => 999
                ],
            ])
            ->add('priceInsc', MoneyType::class, [
                'scale' => 2, 
                'currency' => false,
                'required' => false,
            ])
            ->add('totalInsc', MoneyType::class, [
                'scale' => 2, 
                'currency' => false,
                'required' => false,
            ])
            ->add('save', SubmitType::class, ['label' => 'Recalculer inscription'])
            ->add('saveAndPay', SubmitType::class, ['label' => 'Paiements'])
            ->add('update', SubmitType::class, ['label' => 'Mettre à jour les modifications'])
            ->getForm();
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Inscription::class,
            'yearId' => 0,
        ]);
    }
}
