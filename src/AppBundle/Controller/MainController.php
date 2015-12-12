<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use AppBundle\Form\TodoType;

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

    public function otherAction(){
        //$serializer = $this->get('jms_serializer');

        // $allTodos = $serializer->serialize($allTodos, 'json');

        /* $response = new JsonResponse();
         $response->setData(array(
             'todos' => $allTodos
         ));
         return $response; */
    }
}
