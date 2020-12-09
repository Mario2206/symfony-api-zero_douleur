<?php

namespace App\Controller;


use App\Repository\SessionRepository;
use App\Service\Serializer\SessionNormalizer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Serializer;

class SessionController extends AbstractController {

    /**
     * @Route("/api/session/{idSession}", name="app_get_session", methods={"GET"})
     */
    public function getSession ($idSession, SessionRepository $mediaRepository, SessionNormalizer $sessionNormalizer) {

        $session = $mediaRepository->findOneBy(["id"=> $idSession]);

        if($session) {
            
            $serializer = new Serializer([$sessionNormalizer], [new JsonEncoder(), new XmlEncoder()]);

            $jsonMessage = $serializer->serialize($session, "json");
            
            return new JsonResponse(  $jsonMessage , \HTTP_SUCCESS);
        }
        
        return new JsonResponse("No session found", \HTTP_BAD_REQUEST);
    }
}