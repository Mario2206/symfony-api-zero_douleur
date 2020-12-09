<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\HeaderUtils;
use Symfony\Component\Routing\Annotation\Route;

class MediaServeController extends AbstractController {

    /**
     * For serving media file 
     * 
     * @Route("/static/media/{filename}",name="app_serve_file", methods={"GET"})
     */
    public function serveSessionVideo($filename, ParameterBagInterface $parameters) {

        $mediaDir = $parameters->get("media_directory") . "/";
        $response = new BinaryFileResponse($mediaDir . $filename);

        $disposition = HeaderUtils::makeDisposition(
            HeaderUtils::DISPOSITION_ATTACHMENT,    
            $filename
        );

        $response->headers->set('Content-Disposition', $disposition);

        return $response;
    }


}