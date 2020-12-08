<?php

namespace App\Form;

use Doctrine\DBAL\Types\SmallIntType;
use Doctrine\DBAL\Types\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CustomerFeelingsType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add("sessionId", null , [
                "mapped" => !$options['update']
            ])
            ->add("userId", null , [
                "mapped" => !$options['update']
            ])
            ->add("preNotation", null , [
                "mapped" => !$options["update"]
            ])
            ->add("postNotation", null , [
                "mapped" => $options["update"]
            ])
            ->add("postReview", null , [
                "mapped" => $options['update']
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            "update" => false,
            'csrf_protection' => false
        ]);

        $resolver->setAllowedTypes("update", "bool");
    }
}