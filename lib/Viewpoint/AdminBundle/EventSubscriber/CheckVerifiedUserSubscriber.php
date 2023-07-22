<?php
namespace Viewpoint\AdminBundle\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Http\Event\CheckPassportEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class CheckVerifiedUserSubscriber implements EventSubscriberInterface{
    private Security $security;
    private UrlGeneratorInterface $urlGenerator;
    private array $excludedRoutes;

    public function __construct(Security $security, UrlGeneratorInterface $urlGenerator)
    {
        $this->security = $security;
        $this->urlGenerator = $urlGenerator;
        $this-> excludedRoutes = [
            'non_verified_user_page',
            'app_verify_email',
            'app_resend_verify_email'
        ];
        
    }
    public static function getSubscribedEvents(): array
    {
        return [
            // CheckPassportEvent::class => 'onCheckPassport',
            KernelEvents::REQUEST => 'onKernelRequest',
        ];
    }

    public function onCheckPassport(CheckPassportEvent $event)
    {
        // dd(true);
        // $passport = $event->getPassport();
        // $user = $passport->getUser();

        // if (!$user instanceof User) {
        //     throw new \Exception('Unexpected user type');
        // }
        // if (!$user->getIsVerified()) {
        //     dd($user);
        // }
    }

    public function onKernelRequest(RequestEvent $event)
    {
        $currentRoute = $event->getRequest()->attributes->get('_route');

        if (in_array($currentRoute, $this->excludedRoutes)) {
            return;
        }

        if ($this->security->isGranted('IS_AUTHENTICATED_FULLY') && !$this->security->getUser()->isVerified()) {
                $response = new RedirectResponse($this->urlGenerator->generate('non_verified_user_page'));
                $event->setResponse($response);
        }
    }
}