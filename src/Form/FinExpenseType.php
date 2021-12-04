<?php

namespace App\Form;

use App\Entity\FinExpense;
use App\Entity\FinCategory;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class FinExpenseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('numExp', NumberType::class, [
                'data'=>$options['lastNum'],
            ])
            ->add('category', EntityType::class, [
                'class' => FinCategory::class,
                'choice_label' => 'title',
                'choice_value' => 'id',
                'label' => 'Catégorie',
                'required' => true,
            ])
            ->add('dateIn', DateType::class,[
                'widget' => 'single_text',
                'data' => new \DateTime(),
                'label' => 'Date Paiement',
                'required' => true,
            ])
            ->add('payMode', ChoiceType::class, [
                    'choices'  => [
                        'Chèque' => 'Chèque',
                        'Espèces' => 'Espèces',
                        'Virement' => 'Virement',
                        'CB' => 'CB',
                        'Autres' => 'Autres',
                    ],
                    'expanded' => false,
                    'multiple' => false,
                    'required' => true,
                    'label' => 'Mode Paiement',
            ])
            ->add('docNum', TextType::class, ['required' => false])
            ->add('amount', MoneyType::class, [
                'scale' => 2, 
                'currency' => false,
                'required' => true,
            ])
            ->add('notes', TextareaType::class, ['required' => false])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => FinExpense::class,
            'yearId' => 0,
            'lastNum' => 0,
        ]);
    }
}
