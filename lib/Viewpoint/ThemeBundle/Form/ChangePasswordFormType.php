<?php

namespace Viewpoint\ThemeBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class ChangePasswordFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add("currentPassword", PasswordType::class, [
                "label" => "Ancien mot de passe",
                "constraints" => [new NotBlank(message: "champ requis")],
            ])
            ->add("newPassword", RepeatedType::class, [
                "type" => PasswordType::class,
                "invalid_message" => "Les champs de mot de passe doivent correspondre.",
                "first_options" => [
                    "label" => "Nouveau mot de passe",
                    "constraints" => [
                        new NotBlank(),
                        new Length([
                            'min' => 8,
                            'minMessage' => "Le mot de passe doit contenir au moins {{ limit }} caractères.",
                        ]),
                        new Regex([
                            "pattern" =>
                                '/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).*$/',
                            "message" =>
                                "Le mot de passe doit contenir au moins une majuscule, une minuscule, un chiffre et un caractère spécial.",
                        ]),
                    ],
                    "attr" => [
                        "placeholder" => "Entrez le nouveau mot de passe",
                    ],
                ],
                "second_options" => [
                    "label" => "Confirmer mot de passe",
                    "attr" => [
                        "placeholder" => "Confirmez le nouveau mot de passe",
                    ],
                ],
            ]);
    }
}
