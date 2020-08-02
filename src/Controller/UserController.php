<?php
namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\UserEditType;
use App\Repository\CreationTypeRepository;
use App\Repository\UserRepository;
use Hackzilla\PasswordGenerator\Generator\PasswordGeneratorInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 *
 * @Route("/admin/user")
 */
class UserController extends AbstractController
{

    private PasswordGeneratorInterface $generator;

    private UserRepository $repository;

    private UserPasswordEncoderInterface $encoder;

    public function __construct(UserRepository $repository, PasswordGeneratorInterface $generator, UserPasswordEncoderInterface $encoder)
    {
        $this->repository = $repository;
        $this->generator = $generator;
        $this->encoder = $encoder;
    }

    /**
     *
     * @Route("/", name="user_index", methods={"GET"})
     */
    public function index(): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $users = $this->repository->findAll();

        return $this->render('user/index.html.twig', [
            'users' => $users
        ]);
    }

    /**
     *
     * @Route("/new", name="user_new", methods={"GET","POST"})
     */
    public function new(Request $request, CreationTypeRepository $creationTypeRepository): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $password = ($this->generator->generatePasswords())[0];
            $user->setPassword($this->encoder->encodePassword($user, $password));
            $user->setCreationType($creationTypeRepository->findByName('Manual'));

            $this->repository->save($user);

            $this->addFlash('success', sprintf('User %s added with password: %s', $user->getUsername(), $password));
            return $this->redirectToRoute('user_index');
        }

        return $this->render('user/new.html.twig', [
            'user' => $user,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/export", name="user_export")
     */
    public function export(): Response
    {
        return $this->redirectToRoute('user_index');
    }


    /**
     *
     * @Route("/{id}/edit", name="user_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, User $user): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $form = $this->createForm(UserEditType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $this->addFlash('success', sprintf('User %s Updated', $user->getUsername()));
            return $this->redirectToRoute('user_index');
        }

        return $this->render('user/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView()
        ]);
    }

    /**
     *
     * @Route("/{id}", name="user_delete", methods={"DELETE"})
     */
    public function delete(Request $request, User $user): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        if ($this->isCsrfTokenValid('delete' . $user->getId(), $request->request->get('_token'))) {
            $this->repository->remove($user);

            $this->addFlash('success', sprintf('User %s Deleted', $user->getUsername()));
        }

        return $this->redirectToRoute('user_index');
    }
}
