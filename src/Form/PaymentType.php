<?php

namespace App\Form;

use App\Entity\Payment;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class PaymentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('datePay', DateType::class,[
                'label' => 'Date Paiement',
                'widget' => 'single_text',
                'data' => new \DateTime()
            ])
            ->add('modePay', ChoiceType::class, [
                    'choices'  => [
                        'Chèque' => 'Chèque',
                        'Chèque ANCV' => 'Chèque ANCV',
                        'Chèque VACAF' => 'Chèque VACAF', //Uniquement pour les séjour AVEC HEBERGEMENT
                        'Espèces' => 'Espèces',
                        'Virement' => 'Virement',
                        'CB' => 'CB',
                    ],
                    'expanded' => false,
                    'multiple' => false,
                    'required' => true,
                    'label' => 'Avec Repas ',
            ])
            ->add('amount', MoneyType::class, [
                'scale' => 2, 
                'currency' => false,
                'required' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Payment::class,
        ]);
    }
}
