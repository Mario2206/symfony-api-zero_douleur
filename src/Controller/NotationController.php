<?php

namespace App\Controller;

use App\Entity\CustomerFeelings;
use App\Entity\Session;
use App\Form\CustomerFeelingsType;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class NotationController extends AbstractController {


    /**
     * For posting notation before taking part to the session
     * 
     * @Route("/api/session/{sessionId}/notation", name="app_set_notation", methods={"POST"})
     */
    public function postPreNotation($sessionId, Request $req) {

        $jsonRequest = $req->request->all();

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
                $customerFeelings->setSessionId($sessionId);
                $em->persist($customerFeelings);
                $em->flush();

                $response = new JsonResponse( ["customerFeelingsId" => $customerFeelings->getId()], \HTTP_CREATED); 

                return $response;
            }
            
            return new JsonResponse(["message" => "The session doesn't exist"], HTTP_NOT_FOUND);

        }

        return new JsonResponse($feelingsForm->getErrors(true), \HTTP_BAD_REQUEST);

    }

    /**
     * 
     * For posting notation after taking part to the session
     * 
     * @Route("/api/session/{sessionId}/notation", name="app_update_notation", methods={"PUT"})
     */
    public function postEndNotation($sessionId, Request $req) {

        $feelingsId = $req->request->get("customerFeelingsId");

        if(!$feelingsId) {

            return new JsonResponse(["message" => "The customer isn't authentify"], HTTP_BAD_REQUEST);

        }

        $em = $this->getDoctrine()->getManager();
        $customerFeelings = $em->find(CustomerFeelings::class,$feelingsId);

        if(!$customerFeelings) {
            return new JsonResponse(["message" => "The initial customer feeling doesn't exist"], HTTP_NOT_FOUND);
        } 

        $form = $this->createForm(CustomerFeelingsType::class, $customerFeelings, ["update"=>true]);

        $form->submit($req->request->all());
        
        if(!$form->isValid()) {
            return new JsonResponse($form->getErrors(true), HTTP_BAD_REQUEST);
        }

        $customerFeelings->setFinishAt(new DateTime());
        $em->persist($customerFeelings);
        $em->flush();

        return new JsonResponse(["message" => "Notation registered !"], \HTTP_SUCCESS);
    }
}