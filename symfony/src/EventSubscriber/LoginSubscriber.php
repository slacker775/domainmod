<?php
namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use App\Repository\SettingRepository;
use Symfony\Component\Security\Http\SecurityEvents;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;

class LoginSubscriber implements EventSubscriberInterface, LoggerAwareInterface
{
    use LoggerAwareTrait;

    private SessionInterface $session;

    private SettingRepository $settingRepository;

    public function __construct(SessionInterface $session, SettingRepository $settingRepository)
    {
        $this->session = $session;
        $this->settingRepository = $settingRepository;
    }

    public function onSecurityInteractiveLogin(InteractiveLoginEvent $event)
    {
        $this->logger->info('Storing system settings in session');

        $settings = $this->settingRepository->getSettings();
        $this->session->set('settings', $settings);
    }

    public static function getSubscribedEvents()
    {
        return [
            SecurityEvents::INTERACTIVE_LOGIN => 'onSecurityInteractiveLogin'
        ];
    }
}
