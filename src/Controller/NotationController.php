<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\BrowserKit\Request;

class NotationController extends AbstractController {

    /**
     * @Route("/api/session/{sessionId}", name="app_set_notation", methods={"POST"})
     */
    public function postNotation($sessionId, Request $req) {
        
    }
}