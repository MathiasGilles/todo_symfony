<?php

namespace App\Controller;

use App\Form\UserType;
use App\Form\EditUserType;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserController extends AbstractController
{
    /**
     * @Route("/", name="user")
     */
    public function index(UserRepository $repo)
    {
        $users = $repo->findAll();
        if ($user = null) {
            return $this->render('user/index.html.twig');
        }
        else{
        return $this->render('user/index.html.twig', [
            'users' => $users,
        ]);
        }
    }

    /**
     * @Route("/user/edit/{id}",name="user_edit")
     */
    public function edit($id = null ,Request $request,UserRepository $repo)
    {
        if ($id != null) {
            
            $manager = $this->getDoctrine()->getManager();
            $user = $repo->find($id);

            $form = $this->createForm(EditUserType::class, $user);
            $form->handleRequest($request);

            $manager->persist($user);
            $manager->flush();
        }
        return $this->render('user/user_edit.html.twig',[
            'formEditUser' => $form->createView(),
        ]);

    }

    /**
     * @Route("/user/delete/{id}",name="user_delete")
     */
    public function delete($id = null ,Request $request,UserRepository $repo)
    {   
        
        if ($id != null) {
            $user = $repo->find($id);
            $manager=$this->getDoctrine()->getManager();
            $manager->remove($user);
            $manager->flush();

        }
        return $this->redirectToRoute('user');
    }

    /**
     * @Route("/user/{id}",name="user_detail")
     */
    public function detail($id,UserRepository $repo)
    {
        $user = $repo->find($id);

        return $this->render('user/user_detail.html.twig',[
            'user' => $user,
        ]);
    }

}   

