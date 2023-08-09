<?php

namespace Viewpoint\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\RadioType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Viewpoint\AdminBundle\Entity\User;

class ProfileCompletionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add("firstName", TextType::class)
            ->add("lastName", TextType::class)
            ->add("sexe", ChoiceType::class, [
                "choices" => [
                    "Homme" => "M",
                    "Femme" => "F",
                ],
                "expanded" => true,
                "multiple" => false,
            ])
            ->add("birth", DateType::class, [
                "widget" => "single_text",
            ])
            ->add("profile", FileType::class, [
                "help" =>
                    "Avec une photo, vous avez de quoi personnaliser votre profil et rassurer les autres membres!",
                "required" => false,
                "mapped" => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            "data_class" => User::class,
        ]);
    }
}
