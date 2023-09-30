<?php

namespace Viewpoint\ThemeBundle\Form;

use Doctrine\ORM\EntityManagerInterface;
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
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Validator\Constraints\IsTrue;
use Viewpoint\ThemeBundle\Entity\City;
use Viewpoint\ThemeBundle\Entity\Currency;

class RoomFormType extends AbstractType
{
    public function __construct(
        private Security $security,
        private EntityManagerInterface $entityManager
    ) {
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add("departureLocation", TextType::class, [
                "label" => "Ville de depart",
                "help" => "Mettre les informations necessaires",
                "mapped" => false,
            ])
            ->add("arrivalLocation", TextType::class, [
                "label" => "Ville d’arrivée",
                "help" => "Mettre les informations necessaires",
                "mapped" => false,
            ])
            ->add("departureDate", DateType::class, [
                "label" => "Date de depart ",
                "help" => "Preciser votre date départ",
                "widget" => "single_text",
                "attr" => [
                    "class" => "gp-room-datepicker",
                ],
            ])
            ->add("arrivalDate", DateType::class, [
                "label" => "Date d'arrivée",
                "help" => "Preciser votre date d'arrivée",
                "widget" => "single_text",
                "attr" => [
                    "class" => "gp-room-datepicker",
                ],
                "required" => false
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
            ->add("currency", EntityType::class, [
                "class" => Currency::class,
                "choice_label" => function ($currency) {
                    return $currency->getSymbol() . " - " . $currency->getName();
                },
                "label" => "Devise",
                "help" => "Entrer le code de la devise utilisée, par exemple : XOF",
            ])
            ->add("unitPrice", TextType::class, [
                "label" => "Prix unitaire",
                "help" => "Saisir le prix par kg",
                "required" => false
            ])
            ->add("weight", TextType::class, [
                "label" => "Espace",
                "help" => "Saisir la taille de votre sac",
                "required" => false
            ])
            ->add("codeConducts", CheckboxType::class, [
                "mapped" => false,
                "constraints" => [
                    new IsTrue([
                        "message" => "Vous devez accepter nos conditions.",
                    ]),
                ],
            ])
            ->add("securityMeasures", CheckboxType::class, [
                "mapped" => false,
                "constraints" => [
                    new IsTrue([
                        "message" => "Vous devez accepter nos mesures de sécurité.",
                    ]),
                ],
            ]);

        $user = $this->security->getUser();

        if (!$user) {
            throw new \LogicException(
                "The RoomCreationFormType cannot be used without an authenticated user!"
            );
        }

        $builder->addEventListener(FormEvents::SUBMIT, function (FormEvent $event) use (
            $user
        ): void {
            /** @var Room */
            $entity = $event->getData();

            if ($entity instanceof Room && !$entity->getUser()) {
                $entity->setUser($user);
            }

            if ($entity instanceof Room && !$entity->getRoomMetaKeyword()) {
                $entity->setRoomMetaKeyword(null);
            }
            // setting the departure and arrival location data since not mapped
            $form = $event->getForm();

            $departureLocationFormData = $form->get("departureLocation")->getData();
            $arrivalLocationFormData = $form->get("arrivalLocation")->getData();

            if ($departureLocationFormData) {
                $departureCity = $this->entityManager
                    ->getRepository(City::class)
                    ->findOneBy(["name" => $departureLocationFormData]);

                if ($departureCity && $departureCity != $entity->getDepartureLocation()) {
                    $entity->setDepartureLocation($departureCity);
                }
            }

            if ($arrivalLocationFormData) {
                $arrivalCity = $this->entityManager
                    ->getRepository(City::class)
                    ->findOneBy(["name" => $arrivalLocationFormData]);

                if ($arrivalCity && $arrivalCity != $entity->getArrivalLocation()) {
                    $entity->setArrivalLocation($arrivalCity);
                }
            }

            $event->setData($entity);
        });

        $builder->addEventListener(FormEvents::POST_SET_DATA, function (FormEvent $event) {
            /** @var Room|null */
            $room = $event->getData();
            $form = $event->getForm();

            if (!$room) {
                return;
            }

            // Get the current departure and arrival locations
            $departureLocation = $room->getDepartureLocation();
            $arrivalLocation = $room->getArrivalLocation();
            
            $form
                ->get("departureLocation")
                ->setData($departureLocation ? $departureLocation->getName() : null);
            $form
                ->get("arrivalLocation")
                ->setData($arrivalLocation ? $arrivalLocation->getName() : null);
        });
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            "data_class" => Room::class,
        ]);
    }
}
