<?php

namespace App\Form;

use App\Entity\ArrayList;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class ArrayListType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('rateTitle', CollectionType::class, [
                'entry_type' => TextType::class,
                'allow_add'    => true,
                'allow_delete' => true,
                'label'        => false,
                'by_reference' => false,
            ])
            ->add('ageGroup', CollectionType::class, [
                'entry_type' => TextType::class,
                'allow_add'    => true,
                'allow_delete' => true,
                'label'        => false,
                'by_reference' => false,
            ])
            ->add('weekType', CollectionType::class, [
                'entry_type' => TextType::class,
                'allow_add'    => true,
                'allow_delete' => true,
                'label'        => false,
                'by_reference' => false,
            ])
            ->add('typeContract', CollectionType::class, [
                'entry_type' => TextType::class,
                'allow_add'    => true,
                'allow_delete' => true,
                'label'        => false,
                'by_reference' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ArrayList::class,
        ]);
    }
}
