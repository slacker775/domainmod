<?php
declare(strict_types=1);
namespace App\EventSubscriber;

use App\Service\SettingsResolver;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Security\Http\SecurityEvents;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;

class LoginSubscriber implements EventSubscriberInterface, LoggerAwareInterface
{
    use LoggerAwareTrait;

    private SessionInterface $session;
        
    private SettingsResolver $resolver;

    public function __construct(SessionInterface $session, SettingsResolver $resolver)
    {
        $this->session = $session;
        $this->resolver = $resolver;
    }

    public function onSecurityInteractiveLogin(InteractiveLoginEvent $event)
    {
        $this->logger->info('Storing system settings in session');

        $user = $event->getAuthenticationToken()->getUser();
        $this->session->set('settings', $this->resolver->resolveSettings($user));        
    }

    public static function getSubscribedEvents()
    {
        return [
            SecurityEvents::INTERACTIVE_LOGIN => 'onSecurityInteractiveLogin'
        ];
    }
}
