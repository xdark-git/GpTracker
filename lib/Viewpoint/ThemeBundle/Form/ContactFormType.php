<?php 

namespace Viewpoint\ThemeBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Viewpoint\ThemeBundle\Data\ContactData;


class ContactFormType extends AbstractType {
    public function buildForm(FormBuilderInterface $builder, array $options): void{
        $builder
            ->add("firstname", TextType::class, [
                "label" => "prenom",
                "attr"=>[
                    "placeholder"=> "Entrer votre prenom",
                ],
            ])
            ->add("lastname", TextType::class, [
                "label" => "nom",
                "attr"=>[
                    "placeholder"=> "Entrer votre nom",
                ],
            ])
            ->add("object", TextType::class, [
                "label" => "objet",
                "attr"=>[
                    "placeholder"=> "Entrer l'objet du message",
                ],
            ])
            ->add("email", EmailType::class, [
                "label" => "email",
                "attr" => [
                    "placeholder" => "Entrer votre email"
                ] 
            ])
            ->add("message", TextareaType::class , [
                "label" => "message",
                "attr" =>[
                    "placeholder" => "Entrer votre message..."
                ]
            ]);   
    }
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            "data_class" => ContactData::class,
        ]);
    }
}