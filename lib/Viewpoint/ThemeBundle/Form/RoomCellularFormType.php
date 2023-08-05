<?php

namespace Viewpoint\ThemeBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Viewpoint\ThemeBundle\Entity\RoomCellular;

class RoomCellularFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add("primary", TextType::class, [
                "label" => "Numéro de téléphone WhatsApp",
                "help" => "Veuillez entrer un format valide, par exemple : +1 XXX XXX XXXX",
            ])
            ->add("secondary", TextType::class, [
                "label" => "Numéro de téléphone secondaire",
                "help" => "Veuillez entrer un format valide, par exemple : +1 XXX XXX XXXX",
                "required" => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            "data_class" => RoomCellular::class,
        ]);
    }
}
