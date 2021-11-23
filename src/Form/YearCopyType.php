<?php

namespace App\Form;

use App\Entity\Year;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

class YearCopyType extends AbstractType
{
   
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $copy = $options['copyYear'];
        foreach ($copy as $key => $value) {
            if ($key == 'priceMeal')
                $priceMeal = $value;
            if ($key == 'priceInscription')
                $priceInscription = $value;
            if ($key == 'numHabilitation')
                $numHabilitation = $value;
        }

        $builder
            ->add('year', NumberType::class, ['data' => null])
            ->add('priceMeal', MoneyType::class, ['scale' => 2, 'data' => $priceMeal])
            ->add('priceInscription', MoneyType::class, ['scale' => 2, 'data' => $priceInscription])
            ->add('numHabilitation', TextType::class, ['data' => $numHabilitation])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Year::class,
            'copyYear' => [],
        ]);
    }
}
