<?php 

namespace App\Form;


use App\Entity\Media;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class MediaFileType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add("contentTitle", TextType::class)
            ->add("contentDescription", TextType::class)
            ->add("contentCategory", TextType::class)
            ->add("contentTags", TextType::class)
            ->add("mediaFile", FileType::class, [
                "label" => "MediaFile",
                "mapped" => false,
                "required" => false,
                "constraints" => [
                    new File([
                        "maxSize" => "100m",
                        "mimeTypes" => [     
                            "audio/mpeg",
                            "video/mp4"
                        ],
                        "mimeTypesMessage" => "Please upload a valid audio file (like mp3 or mp4)"
                    ])
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            "data_class"=>Media::class,
            'csrf_protection' => false
        ]);
    }

}