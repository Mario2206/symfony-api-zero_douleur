<?php

namespace App\Controller;

use App\Entity\CustomerFeelings;
use App\Form\CustomerFeelingsType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\BrowserKit\Request;
use Symfony\Component\BrowserKit\Response;
use Symfony\Component\Routing\Annotation\Route;

class NotationController extends AbstractController {

    /**
     * @Route("/api/session/{sessionId}", name="app_set_notation", methods={"POST"})
     */
    public function postPreNotation($sessionId, Request $req) {

        $jsonRequest = json_decode($req->getContent());
        $jsonRequest["session_id"] = $sessionId;

        $customerFeelings = new CustomerFeelings();
        $feelingsForm = $this->createForm(CustomerFeelingsType::class, $customerFeelings);
        $feelingsForm->submit($jsonRequest);

        if($feelingsForm->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($customerFeelings);
            $em->flush();

            return new Response("Pre-notation registered", \HTTP_CREATED);

        }

        return new Response($feelingsForm->getErrors(true), \HTTP_BAD_REQUEST);

    }

    /**
     * @Route("/api/session/{sessionId}", name="app_set_notation", methods={"PUT"})
     */
    public function postEndNotation() {

    }
}