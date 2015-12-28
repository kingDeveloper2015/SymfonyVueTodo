<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use AppBundle\Form\TodoType;
use AppBundle\Entity\Todo;

class MainController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {

        $repository = $this->getDoctrine()->getRepository('AppBundle:Todo');
        $allTodos   = $repository->findAll();
        $todoNumber = count($allTodos);

        $form = $this->createForm(TodoType::class);
        $form->handleRequest($request);

        if ($form->isValid()) {

            $todo = $form->getData();
            $em = $this->getDoctrine()->getManager();

            if($todoNumber < 10){
                $em->persist($todo);
                $em->flush();
            }

            return $this->redirectToRoute('homepage');
        }

        return $this->render('main/index.html.twig', array('todos'=>$allTodos, 'form'=>$form->createView()));
    }

    /**
     * @Route("/api/todos", name="getTodos")
     * @Method({"GET"})
     */
    public function getTodosAction(){
        $repository = $this->getDoctrine()->getRepository('AppBundle:Todo');
        $allTodos   = $repository->findAll();
        $serializer = $this->get('jms_serializer');

        $allTodos = $serializer->serialize($allTodos, 'json');

        $response = new JsonResponse($allTodos);

        return $response;
    }

    /**
     * @Route("/api/todos", name="createTodo")
     * @Method({"POST"})
     */
    public function createTodoAction(Request $request)
    {
        $number = $this->getDoctrine()->getRepository('AppBundle:Todo')->getTodosNumber();
        if( $number >= 10 ){

            $response = new JsonResponse('You are too busy bro... You can\'t have other tasks :) ');

            return $response;
        }
        $body = $request->getContent();

        $data = json_decode($body, true);

        $todo = new Todo();

        $todo->setDescription($data['description']);

        $em = $this->getDoctrine()->getManager();

        $em->persist($todo);
        $em->flush();
        $response = new JsonResponse('cewl');

        return $response;
    }

    /**
     * @Route("/api/todos/{id}", name="getTodo")
     * @Method({"GET"})
     */
    public function getTodoAction(Request $request, $id){

        $todo= $this->getDoctrine()->getRepository('AppBundle:Todo')->find($id);
        $serializer = $this->get('jms_serializer');

        $todo = $serializer->serialize($todo, 'json');

        $response = new JsonResponse($todo);

        return $response;
    }

    /**
     * @Route("/api/todos/{id}", name="getTodo")
     * @Method({"PUT"})
     */
    public function updateTodoAction(Request $request, $id){

        $todo= $this->getDoctrine()->getRepository('AppBundle:Todo')->find($id);
        $serializer = $this->get('jms_serializer');

        $body = $request->getContent();
        $data = json_decode($body, true);

        $todo->setDescription($data['description']);

        $todo->setIsComplete($data['is_complete']);

        $em = $this->getDoctrine()->getManager();

        $em->persist($todo);
        $em->flush();

        $todo = $serializer->serialize($todo, 'json');

        $response = new JsonResponse($todo);

        return $response;
    }

    /**
     * @Route("/api/todos/{id}", name="deleteTodos")
     * @Method({"DELETE"})
     */
    public function deleteTodosAction(Request $request, $id)
    {

        $body = $request->getContent();

        $em = $this->getDoctrine()->getManager();

        $todo= $this->getDoctrine()->getRepository('AppBundle:Todo')->find($id);

        $em->remove($todo);
        $em->flush();

        $response = new JsonResponse('deleted');

        return $response;
    }
}
