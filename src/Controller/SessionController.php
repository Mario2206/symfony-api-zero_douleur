<?php

namespace App\Controller;

use App\Repository\SessionRepository;
use App\Service\Serializer\SessionNormalizer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class SessionController extends AbstractController {

    /**
     * @Route("/api/session/{idSession}", name="app_get_session", methods={"GET"})
     */
    public function getSession ($idSession, SessionNormalizer $sessionNormalizer, SessionRepository $mediaRepository) {

        $session = $mediaRepository->getSession($idSession);
         
        if($session) {


            $serializer = new Serializer([$sessionNormalizer], [new JsonEncoder()]);
            
            $res = $serializer->serialize($session, 'json');
            
            return new JsonResponse(  $res , \HTTP_SUCCESS);
        }
        
        return new JsonResponse("No session found", \HTTP_BAD_REQUEST);
    }


    /**
     * @Route("/api/sessions", name="app_get_all_sessions")
     * @Route("/api/sessions/start/{start}/offset/{offset}", name="app_get_sessions_by_offset")
     * @Route("/api/sessions/start/{start}/offset/{offset}/tag/{tag}", name="app_get_sessions_by_categories")
     * 
     */
    public function getManySessions($start = 0, $offset = 0, $tag = "", SessionRepository $sessionRepository, SessionNormalizer $sessionNormalizer) {
        
        $sessions = $sessionRepository->getMany($start, $offset, $tag);

        $serializer = new Serializer([$sessionNormalizer], [new JsonEncoder()]);

        $data = $serializer->serialize($sessions, "json");

        return new JsonResponse($data);
    }
}