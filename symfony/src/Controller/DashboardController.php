<?php

namespace App\Controller;

use App\Entity\Domain;
use App\Repository\DomainRepository;
use App\Repository\QueueRepository;
use App\Repository\SslCertRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(DomainRepository $domainRepository, SslCertRepository $sslRepository, QueueRepository $queueRepository)
    {
        return $this->render('dashboard/index.html.twig', [
            'activeDomainCount' => $domainRepository->getActiveDomainCount(),
            'activeCertCount' => $sslRepository->getActiveCertificateCount(),
            'expiringDomains' => $domainRepository->getExpiringDomainCount(30),
            'expiringSslCerts' => $sslRepository->getExpiringSslCertCount(30),
            'domainsSold' => $domainRepository->getDomainCountByStatus(Domain::STATUS_SOLD),
            'domainsPendingRenewal' => $domainRepository->getDomainCountByStatus(Domain::STATUS_PENDING_RENEWAL),
            'domainsPendingRegistration' => $domainRepository->getDomainCountByStatus(Domain::STATUS_PENDING_REGISTRATION),
            'domainsPendingTransfer' => $domainRepository->getDomainCountByStatus(Domain::STATUS_PENDING_TRANSFER),
            'domainsPendingOther' => $domainRepository->getDomainCountByStatus(Domain::STATUS_PENDING_OTHER),
            'queuePending' => $queueRepository->getPendingCount(),
            'queueProcessing' => $queueRepository->getProcessingCount(),
            'queueFinished' => $queueRepository->getFinishedCount(),
            'sslPendingRenewal' => $sslRepository->getPendingRenewalCount(),
            'sslPendingRegistration' => $sslRepository->getPendingRegistrationCount(),
            'sslPendingOther' => $sslRepository->getPendingOtherCount()
        ]);
    }
}