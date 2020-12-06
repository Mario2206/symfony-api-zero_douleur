<?php 

namespace App\Form;


use App\Entity\Media;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class MediaFileType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add("title", TextType::class, [
                "empty_data"=> ""
            ])
            ->add("description", TextType::class, [
                "empty_data" => ""
            ])
            ->add("tags", TextType::class, [
                "empty_data" => ""
            ])
            ->add("mediaFile");
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            "data_class"=>Media::class,
            'csrf_protection' => false
        ]);
    }

}