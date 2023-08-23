<?php

namespace Viewpoint\AdminBundle\Service;

use Viewpoint\AdminBundle\Entity\User;
use Viewpoint\AdminBundle\Security\EmailVerifier;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mime\Address;
use Symfony\Component\DependencyInjection\ParameterBag\ContainerBagInterface;

class Emailing
{
    public function __construct(
        private EmailVerifier $emailVerifier,
        private ContainerBagInterface $params
    ) {
    }
    
    public function sendEmailConfirmationHelper(User $user): void
    {
        $noReplyEmail = $this->params->get("viewpoint_admin.email_config.no_reply");

        $this->emailVerifier->sendEmailConfirmation(
            "app_verify_email",
            $user,
            (new TemplatedEmail())
                ->from(new Address($noReplyEmail, "no-reply"))
                ->to($user->getEmail())
                ->subject(
                    "Bienvenue sur " . $_ENV["APP_NAME"] . " - Veuillez Confirmer Votre Inscription"
                )
                ->htmlTemplate("registration/confirmation_email.html.twig")
        );
    }
}
