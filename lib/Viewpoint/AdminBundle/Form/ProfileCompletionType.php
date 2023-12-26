<?php

namespace Viewpoint\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\RadioType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Viewpoint\AdminBundle\Entity\User;

class ProfileCompletionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add("firstName", TextType::class, [
                "label" => "Prenom",
            ])
            ->add("lastName", TextType::class, [
                "label" => "Nom",
            ])
            ->add("username", TextType::class, [
                "label" => "Nom d'utilisateur",
            ])
            ->add("sexe", ChoiceType::class, [
                "choices" => [
                    "Homme" => "M",
                    "Femme" => "F",
                ],
                "expanded" => true,
                "multiple" => false,
            ])
            ->add("birth", DateType::class, [
                "label" => "Date de naissance",
                "widget" => "single_text",
            ])
            ->add("profile", FileType::class, [
                "help" =>
                    "Avec une photo, vous avez de quoi personnaliser votre profil et rassurer les autres membres!",
                "required" => false,
                "mapped" => false,
                "constraints" => [
                    new File([
                        "maxSize" => "2M",
                        "maxSizeMessage" => 'La taille de l\'image ne doit pas dépasser 2 Mo.',
                        "mimeTypes" => ["image/jpeg", "image/png"],
                        "mimeTypesMessage" => "Veuillez télécharger une image JPEG ou PNG valide.",
                    ]),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            "data_class" => User::class,
        ]);
    }
}
