<?php

namespace App\Controller;

use App\Form\UserType;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserController extends AbstractController
{
    /**
     * @Route("/", name="user")
     */
    public function index(UserRepository $repo)
    {
        $users = $repo->findAll();
        return $this->render('user/index.html.twig', [
            'users' => $users,
        ]);
    }

    /**
     * @Route("/user/edit/{id}",name="user_edit")
     */
    public function edit($id = null ,Request $request,UserRepository $repo)
    {
        if ($id != null) {
            
            $manager = $this->getDoctrine()->getManager();
            $user = $repo->find($id);

            $form = $this->createForm(UserType::class, $user);
            $form->handleRequest($request);

            $manager->persist($user);
            $manager->flush();

            return $this->redirectToRoute('user');
        }
        return $this->render('security/registration.html.twig',[
            'formUser' => $form->createView(),
        ]);

    }

    /**
     * @Route("/user/delet/{id}",name="user_delete")
     */
    public function delete()
    {

    }
}   
