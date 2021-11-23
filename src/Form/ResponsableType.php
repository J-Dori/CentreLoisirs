<?php

namespace App\Form;

use App\Entity\Responsable;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class ResponsableType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('relation', ChoiceType::class, [
                'choices'  => [
                    'Mère' => "Mère",
                    'Père' => "Père",
                    'Tuteur' => "Tuteur",
                ],
                "placeholder" => "---"
            ])
            ->add('title', ChoiceType::class, [
                'choices'  => [
                    '---' => null,
                    'Mme' => "Mme",
                    'Mr' => "Mr",
                ],
            ])
            ->add('lname', TextType::class)
            ->add('fname', TextType::class)
            ->add('address', TextType::class)
            ->add('cp', TextType::class)
            ->add('city', TextType::class)
            ->add('email', EmailType::class)
            ->add('phoneMob', TextType::class)
            ->add('phoneHome', TextType::class, ['required' => false])
            ->add('workName', TextType::class, ['required' => false])
            ->add('workPhone', TextType::class, ['required' => false])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Responsable::class,
        ]);
    }
}
