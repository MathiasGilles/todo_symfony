<?php

namespace App\Controller;

use App\Entity\Task;
use App\Form\TaskType;
use App\Repository\TaskRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TaskController extends AbstractController
{
    /**
     * @Route("/task", name="task")
     */
    public function index(TaskRepository $repo)
    {   
        $tasks=$repo->findAll();

        return $this->render('task/index.html.twig', [
            'tasks' => $tasks,
        ]);
    }

    /**
     * @Route("/task/new",name="task_new")
     * @Route("/task/edit/{id}",name="task_edit")
     */
    public function new(Task $task = null,Request $request)
    {
        if (!$task) {
            $task = new Task();
        }
        $manager=$this->getDoctrine()->getManager();
        $form = $this->createForm(TaskType::class, $task);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) 
        {
            $manager->persist($task);
            $manager->flush();
            return $this->redirectToRoute('task');
        }
        return $this->render('task/task_new.html.twig',[
            'formTask' => $form->createView(),
            'editTitle' => $task->getId() != null,
            'editMode' => $task->getId() != null
        ]);
    }

    /**
     * @Route("/task/delete/{id}",name="task_delete")
     */
    public function delete($id = null ,Request $request,TaskRepository $repo)
    {   
        
        if ($id != null) {
            $task = $repo->find($id);
            $manager=$this->getDoctrine()->getManager();
            $manager->remove($task);
            $manager->flush();

        }
        return $this->redirectToRoute('task');
    }

    /**
     * @Route("/task/detail/{id}",name="task_detail")
     */
    public function detail($id,TaskRepository $repo){

        $task = $repo->find($id);

        return $this->render('task/task_detail.html.twig',[
            'task' => $task,
        ]);
    }
}
