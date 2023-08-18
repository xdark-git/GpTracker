<?php

namespace Viewpoint\ThemeBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RoomSortType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add("sort", ChoiceType::class, [
            "label" => false,
            "required" => false,
            "placeholder" => "Trier par :",
            "choices" => [
                "Moins cher" => "cheaper",
                "weight" => "Poids",
            ],
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            "method" => "GET",
            "csrf_protection" => false,
        ]);
    }
}
