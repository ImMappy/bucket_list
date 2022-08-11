<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserController extends AbstractController
{
    /**
     * @return Response
     * @Route("/user",name="user.index")
     */
    public function index(): Response
    {
        return $this->render('pages/user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }

    /**
     * @param Request $request
     * @param UserPasswordEncoder $passwordEncoder
     * @param EntityManagerInterface $manager
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     * @Route("/new_user",name="user.new")
     */
    public function new(Request $request, UserPasswordEncoderInterface $passwordEncoder,EntityManagerInterface $manager)
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $passwordEncoder->encodePassword($user,$user->getPassword());
            $manager->persist($user);
            $manager->flush();

            return $this->redirectToRoute('security.login');
        }
        return $this->render('pages/user/new.html.twig',[
            'user' => $user,
            'form' => $form->createView()
        ]);


    }
}
