<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;
use Viewpoint\AdminBundle\Entity\User;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email')
            ->add('username')
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'Vous devez accepter nos conditions.',
                    ]),
                ],
            ])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'Les champs de mot de passe doivent correspondre.',
                'first_options'  => ['label' => 'Password', 'attr' => [
                    'placeholder' => 'Entrez votre Mot de passe'
                ]],
                'second_options' => ['label' => 'Repeat Password', 'attr' => [
                    'placeholder' => 'Confirmez le mot de passe'
                ]],
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
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
