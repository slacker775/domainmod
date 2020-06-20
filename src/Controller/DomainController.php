<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\DomainRepository;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Domain;
use Symfony\Component\HttpFoundation\Response;
use App\Form\DomainType;
use App\Repository\RegistrarRepository;
use App\Repository\CreationTypeRepository;
use App\Repository\UserRepository;

/**
 *
 * @Route("/domain")
 *
 */
class DomainController extends AbstractController
{

    /**
     *
     * @Route("/", name="domain_index")
     */
    public function index(DomainRepository $repository)
    {
        return $this->render('domain/index.html.twig', [
            'controller_name' => 'DomainController',
            'domains' => $repository->findBy([], [
                'domain' => 'ASC'
            ]),
            'systemLargeMode' => false,
            'systemDisplayDomainExpiryDate' => true,
            'systemDisplayDomainOwner' => false,
            'systemDisplayDomainFee' => true,
            'systemDisplayDomainTld' => true,
            'systemDisplayDomainRegistrar' => false,
            'systemDisplayDomainAccount' => true,
            'systemDisplayDomainDns' => true,
            'systemDisplayDomainIp' => false,
            'systemDisplayDomainHost' => false,
            'systemDisplayDomainCategory' => true,
            'sortBy' => 'dn_a'
        ]);
    }

    /**
     *
     * @Route("/new", name="domain_new", methods={"GET","POST"})
     */
    public function new(Request $request, DomainRepository $repository, RegistrarRepository $registrarRepository, CreationTypeRepository $creationTypeRepository): Response
    {
        $domain = new Domain();
        $form = $this->createForm(DomainType::class, $domain);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();

            $domain->setTld()
                ->setOwner($domain->getAccount()
                ->getOwner())
                ->setRegistrar($domain->getAccount()
                ->getRegistrar())
                ->setFee($registrarRepository->getFeeByTld($domain->getAccount()
                ->getRegistrar(), $domain->getTld()))
                ->setCreationType($creationTypeRepository->findByName('Manual'))
                ->setCreatedBy($this->getUser());
            $repository->save($domain);
            $entityManager->flush();
            
            $this->addFlash('success', sprintf('Domain %s Added', $domain->getDomain()));          
            return $this->redirectToRoute('domain_index');
        }

        return $this->render('domain/new.html.twig', [
            'domain' => $domain,
            'form' => $form->createView()
        ]);
    }

    /**
     *
     * @Route("/raw", name="domain_raw")
     */
    public function raw(DomainRepository $repository)
    {
        return $this->render('domain/raw.html.twig', [
            'domains' => $repository->findAll()
        ]);
    }

    /**
     *
     * @Route("/export", name="domain_export")
     */
    public function export()
    {
        return $this->redirectToRoute('domain_index');
    }

    /**
     *
     * @Route("/{id}", name="domain_show", methods={"GET"})
     */
    public function show(Domain $domain): Response
    {
        return $this->render('domain/show.html.twig', [
            'domain' => $domain
        ]);
    }

    /**
     *
     * @Route("/{id}/edit", name="domain_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Domain $domain): Response
    {
        $form = $this->createForm(DomainType::class, $domain);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()
                ->getManager()
                ->flush();
            $this->addFlash('success', sprintf('Domain %s Updated', $domain->getDomain()));
            return $this->redirectToRoute('domain_index');
        }

        return $this->render('domain/edit.html.twig', [
            'domain' => $domain,
            'form' => $form->createView(),
            'minDate' => gmdate("Y-m-d", mktime(date("H"), date("i"), date("s"), date("m"), date("d"), date("Y") - 9)),
            'maxDate' => gmdate("Y-m-d", mktime(date("H"), date("i"), date("s"), date("m"), date("d"), date("Y") + 10))
        ]);
    }

    /**
     *
     * @Route("/{id}", name="domain_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Domain $domain): Response
    {
        if ($this->isCsrfTokenValid('delete' . $domain->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($domain);
            $entityManager->flush();
            $this->addFlash('success', sprintf('Domain %s Deleted', $domain->getDomain()));           
        }

        return $this->redirectToRoute('domain_index');
    }

}
