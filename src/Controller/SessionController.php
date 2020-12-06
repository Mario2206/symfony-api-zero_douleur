<?php

namespace App\Controller;

use App\Repository\MediaRepository;
use App\Service\Serializer\ISerializerFactory;
use App\Service\Serializer\SerializerFactory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class SessionController extends AbstractController {

    /**
     * @Route("/api/session/{idSession}", name="app_get_session", methods={"GET"})
     */
    public function getSession ($idSession, MediaRepository $mediaRepository, ISerializerFactory $serializerFactory) {

        $session = $mediaRepository->findOneBy(["id"=> $idSession]);

        if($session) {

            $serializer = $serializerFactory->create();

            $jsonMessage = $serializer->serialize($session, "json");
            
            return new JsonResponse(  $jsonMessage , \HTTP_SUCCESS);
        }
        
        return new JsonResponse("No session found", \HTTP_BAD_REQUEST);
    }
}