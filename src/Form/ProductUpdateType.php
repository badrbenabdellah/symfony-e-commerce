<?php

namespace App\Form;

use App\Entity\Product;
use App\Entity\SubCategory;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class ProductUpdateType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('description')
            ->add('price')
            ->add('image', FileType::class, [
                'label' => 'Product Image',
                'mapped' =>false,
                'required' =>false,
                "constraints" =>[
                    new File([
                        "maxSize" =>"1024k",
                        "mimeTypes" =>[
                            'image/jpg',
                            'image/png',
                            'image/jpeg',
                        ],
                        "maxSizeMessage" => 'your image must not exceed 1024 kb',
                        "mimeTypesMessage" => "Your Product Image must be in a valid format (png, jpg, jpeg)"
                    ])
                ]
            ])
            #->add('stock')
            ->add('subCategories', EntityType::class, [
                'class' => SubCategory::class,
                'choice_label' => 'name',
                'multiple' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
