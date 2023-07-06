<?php

namespace Viewpoint\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;

class LoginFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add("email", EmailType::class, [
                "constraints" => [
                    new NotBlank(["message" => "Please enter your email."]),
                    new Email(["message" => "Invalid email address."]),
                ],
            ])
            ->add("password", PasswordType::class,  [
                "constraints" => [
                    new NotBlank(["message" => "Please enter your password."]),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // enable/disable CSRF protection for this form
            "csrf_protection" => true,
            // the name of the hidden HTML field that stores the token
            "csrf_field_name" => "_token",
            // an arbitrary string used to generate the value of the token
            // using a different string for each form improves its security
            "csrf_token_id" => "task_item",
        ]);
    }
}
