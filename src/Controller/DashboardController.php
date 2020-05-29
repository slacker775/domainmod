<?php

namespace App\Controller;

use App\Entity\Domain;
use App\Repository\DomainRepository;
use App\Repository\SslCertRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractController
{
    /**
     * @Route("/dashboard-new", name="homepage")
     */
    public function index(DomainRepository $domainRepository, SslCertRepository $sslRepository)
    {
        return $this->render('dashboard/index.html.twig', [
            'activeDomainCount' => $domainRepository->getActiveDomainCount(),
            'activeCertCount' => $sslRepository->getActiveCertificateCount(),
            'domainsSold' => $domainRepository->getDomainCountByStatus(Domain::STATUS_SOLD),
            'domainsPendingRenewal' => $domainRepository->getDomainCountByStatus(Domain::STATUS_PENDING_RENEWAL),
            'domainsPendingRegistration' => $domainRepository->getDomainCountByStatus(Domain::STATUS_PENDING_REGISTRATION),
            'domainsPendingTransfer' => $domainRepository->getDomainCountByStatus(Domain::STATUS_PENDING_TRANSFER),
            'domainsPendingOther' => $domainRepository->getDomainCountByStatus(Domain::STATUS_PENDING_OTHER),
            'controller_name' => 'Dashboard'
        ]);
    }
}
