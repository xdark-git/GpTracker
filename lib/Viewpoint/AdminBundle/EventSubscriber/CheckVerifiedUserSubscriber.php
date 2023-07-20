<?php
namespace Viewpoint\AdminBundle\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Http\Event\CheckPassportEvent;
use Viewpoint\AdminBundle\Entity\User;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class CheckVerifiedUserSubscriber implements EventSubscriberInterface{
    private Security $security;
    private UrlGeneratorInterface $urlGenerator;

    public function __construct(Security $security, UrlGeneratorInterface $urlGenerator)
    {
        $this->security = $security;
        $this->urlGenerator = $urlGenerator;
        
    }
    public static function getSubscribedEvents(){
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
        $request = $event->getRequest();
        // Check if the current route requires user authentication
        if ($this->security->isGranted('IS_AUTHENTICATED_FULLY') && !$this->security->getUser()->isVerified()) {
            if ($request->attributes->get('_route') !== 'non_verified_user_page') {
                $response = new RedirectResponse($this->urlGenerator->generate('non_verified_user_page'));
                $event->setResponse($response);
            }
        }
    }
}