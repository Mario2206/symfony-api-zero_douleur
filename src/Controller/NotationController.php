<?php

namespace App\Controller;

use App\Entity\CustomerFeelings;
use App\Entity\Session;
use App\Form\CustomerFeelingsType;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NotationController extends AbstractController {

    /**
     * For posting notation before taking part to the session
     * 
     * @Route("/api/session/{sessionId}", name="app_set_notation", methods={"POST"})
     */
    public function postPreNotation($sessionId, Request $req) {

        $jsonRequest = $req->request->all();
        
        $jsonRequest["sessionId"] = $sessionId;

        if($user = $this->getUser()) {
            $jsonRequest["userId"] = $user->getId();
        }
        

        $customerFeelings = new CustomerFeelings();
        $feelingsForm = $this->createForm(CustomerFeelingsType::class, $customerFeelings);
        $feelingsForm->submit($jsonRequest);

        if($feelingsForm->isValid()) {

            $em = $this->getDoctrine()->getManager();

            $session = $em->find(Session::class, $sessionId);

            if($session) {
                $em->persist($customerFeelings);
                $em->flush();

                $cookie =  Cookie::create("customerFeelingsId")
                            ->withValue($customerFeelings->getId())
                            ->withExpires( strtotime("now + 12 hours"))
                            ->withDomain("localhost")
                            ->withPath( "/" );

                $response = new Response( "Notation registered !", \HTTP_CREATED); 

                $response->headers->setCookie($cookie);

                return $response;
            }
            
            return new Response("The session doesn't exist", HTTP_NOT_FOUND);

        }

        return new Response($feelingsForm->getErrors(true), \HTTP_BAD_REQUEST);

    }

    /**
     * 
     * For posting notation after taking part to the session
     * 
     * @Route("/api/session/{sessionId}", name="app_update_notation", methods={"PUT"})
     */
    public function postEndNotation($sessionId, Request $req) {

        $customerFeelingsId = $req->cookies->get("customerFeelingsId");

        if(!$customerFeelingsId) {

            return new Response("The customer isn't authentify", HTTP_BAD_REQUEST);

        }

        $em = $this->getDoctrine()->getManager();
        $customerFeelings = $em->find(CustomerFeelings::class,$customerFeelingsId);

        if(!$customerFeelings) {
            return new Response("The initial customer feeling doesn't exist", HTTP_NOT_FOUND);
        } 

        $form = $this->createForm(CustomerFeelingsType::class, $customerFeelings, ["update"=>true]);

        $form->submit($req->request->all());
        
        if(!$form->isValid()) {
            return new Response($form->getErrors(true), HTTP_BAD_REQUEST);
        }

        $customerFeelings->setFinishAt(new DateTime());
        $em->persist($customerFeelings);
        $em->flush();

        return new Response("Notation registered !", \HTTP_SUCCESS);
    }
}