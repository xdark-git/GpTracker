<?php

namespace Viewpoint\ThemeBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Viewpoint\ThemeBundle\Data\SearchData;

class SearchFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add("departureLocation", TextType::class, [
                "label" => false,
                "required" => false,
                "attr" => [
                    "placeholder" => "Ville de départ",
                ],
            ])
            ->add("arrivalLocation", TextType::class, [
                "label" => false,
                "required" => false,
                "attr" => [
                    "placeholder" => "Ville d'arrivée",
                ],
            ])
            ->add("minDate", DateType::class, [
                "label" => false,
                "widget" => "single_text",
                "required" => false,
                // "data" => new \DateTime(),
            ])
            ->add("maxDate", DateType::class, [
                "label" => false,
                "widget" => "single_text",
                "required" => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            "data_class" => SearchData::class,
            "method" => "GET",
            "csrf_protection" => false,
        ]);
    }
}
