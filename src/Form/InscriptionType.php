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
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class InscriptionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('numInsc', NumberType::class, [
                'data'=>$options['lastNum'],
                'disabled' => true
            ])
            ->add('notes', TextareaType::class, [
                'required' => false
            ])
            ->add('rate', EntityType::class, [
                'placeholder' => '---',
                'class' => Rate::class,
                'query_builder' => function(RateRepository $repo) use ($options) {
                    return $repo->createQueryBuilder('r')
                                ->andWhere('r.year = :val')
                                ->setParameter('val', $options['yearId']);
                },
                'choice_label' => 'title',
                'choice_value' => 'id',
                'mapped' => false
            ])
            ->add('responsable', EntityType::class, [
                'placeholder' => '---',
                'class' => Responsable::class,
                'mapped' => false
            ])
            ->add('inscriptionDetails', CollectionType::class, [
                'entry_type'   => InscriptionDetailType::class,
                'allow_add'    => true,
                'allow_delete' => true,
                'label'        => false,
                'by_reference' => false,
                'entry_options' => ['yearId' => [$options['yearId']] ],
            ])
            ->add('save', SubmitType::class, ['label' => 'Enregistrer inscription'])
            ->getForm();
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Inscription::class,
            'lastNum' => 0,
            'yearId' => 0,
        ]);
    }
}
