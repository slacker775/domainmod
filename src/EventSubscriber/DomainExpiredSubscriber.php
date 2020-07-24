<?php

namespace App\EventSubscriber;

use App\Event\DomainExpired;
use App\Repository\UserRepository;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class DomainExpiredSubscriber implements EventSubscriberInterface, LoggerAwareInterface
{
    use LoggerAwareTrait;

    private MailerInterface $mailer;

    private UserRepository $repository;

    public function __construct(MailerInterface $mailer, UserRepository $repository)
    {
        $this->mailer = $mailer;
        $this->repository = $repository;
    }

    public static function getSubscribedEvents()
    {
        return [
            DomainExpired::NAME => 'onDomainExpired',
        ];
    }

    public function onDomainExpired(DomainExpired $event)
    {
        $domains = $event->getDomains();

        foreach ($domains as $domain) {
            $this->logger->info(sprintf('Domain expired: %s', $domain->getName()));
        }
        $this->sendEmail($domains);
    }

    private function sendEmail(array $domains)
    {
        $message = 'The following domains are currently expired:' . PHP_EOL;
        foreach ($domains as $d) {
            $message .= sprintf("\t%s on %s\n", $d->getName(), $d->getExpiryDate()
                ->format('m/d/Y'));
        }
        $email = (new Email())->from('domainmod@dsservices.com')
            ->subject('Domain Expirations')
            ->text($message);

        $users = $this->repository->getUsersForExpirationEmails();
        foreach ($users as $user) {
            $email->addTo($user->getEmailAddress());
        }
        $this->mailer->send($email);
    }
}
