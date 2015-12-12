<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction()
    {

        //$serializer = $this->get('jms_serializer');

        $repository = $this->getDoctrine()->getRepository('AppBundle:Todo');
        $allTodos = $repository->findAll();

       // $allTodos = $serializer->serialize($allTodos, 'json');

       /* $response = new JsonResponse();
        $response->setData(array(
            'todos' => $allTodos
        ));
        return $response; */
        return $this->render('default/index.html.twig', array('todos'=>$allTodos));
    }
}
