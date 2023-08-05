<?php

namespace Viewpoint\ThemeBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Viewpoint\ThemeBundle\Entity\Conveyance;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Viewpoint\ThemeBundle\Entity\Room;

class RoomCreationType extends AbstractType
{
    public function __construct(private Security $security)
    {
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add("departureLocation", TextType::class, [
                "label" => "Lieu de depart",
                "help" => "Mettre les informations necessaires",
            ])
            ->add("arrivalLocation", TextType::class, [
                "label" => "Lieu d’arrivée",
                "help" => "Mettre les informations necessaires",
            ])
            ->add("departureDate", DateType::class, [
                "label" => "Date de depart ",
                "help" => "Preciser votre date départ",
            ])
            ->add("arrivalDate", DateType::class, [
                "label" => "Date d'arrivée",
                "help" => "Preciser votre date d'arrivée",
            ])
            ->add("cellular", RoomCellularFormType::class)
            ->add("name", TextType::class, [
                "label" => "Nom du salon",
                "help" =>
                    "Saisir le nom que vous souhaitez donner à votre salon ( Min, Max : 5, 15 caractères)",
            ])
            ->add("conveyance", EntityType::class, [
                "class" => Conveyance::class,
                "choice_label" => "name",
                "label" => "Moyen de Transport",
                "help" => "Selectionner votre moyen de tranport",
            ])
            ->add("currency", TextType::class, [
                "label" => "Devise",
                "help" => "Entrer le code de la devise utilisée, par exemple : XOF",
            ])
            ->add("unitPrice", TextType::class, [
                "label" => "Prix unitaire",
                "help" => "Saisir le prix par kg",
            ])
            ->add("weight", TextType::class, [
                "label" => "Espace",
                "help" => "Saisir la taille de votre sac",
            ]);

        $user = $this->security->getUser();

        if (!$user) {
            throw new \LogicException(
                "The RoomCreationFormType cannot be used without an authenticated user!"
            );
        }

        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) use (
            $user
        ): void {
            $form = $event->getForm();
            $entity = $event->getData();

            if ($entity instanceof Room && !$entity->getUser()) {
                $entity->setUser($user);
            }

            if ($entity instanceof Room && !$entity->getRoomMetaKeyword()) {
                $entity->setRoomMetaKeyword(null);
            }

            $form->setData($entity);
        });
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            "data_class" => Room::class,
        ]);
    }
}
