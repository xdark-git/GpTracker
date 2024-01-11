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
use Viewpoint\AdminBundle\Entity\User;
// TODO: delete this class when v2 deployed
class CheckVerifiedUserSubscriber implements EventSubscriberInterface{
    private Security $security;
    private UrlGeneratorInterface $urlGenerator;
    private array $excludedRoutes;

    public function __construct(Security $security, UrlGeneratorInterface $urlGenerator)
    {
        $this->security = $security;
        $this->urlGenerator = $urlGenerator;
        $this->excludedRoutes = [
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

        /** @var User */
        // $user = $this->security->getUser();
        // TODO: refactor this code asap, it will cause weird behavior when user is not verified using api
        // if ($this->security->isGranted('IS_AUTHENTICATED_FULLY') && !$user->isVerified()) {
        //         $response = new RedirectResponse($this->urlGenerator->generate('non_verified_user_page'));
        //         $event->setResponse($response);
        // }
    }
}