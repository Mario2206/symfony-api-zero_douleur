<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController {

    /**
     * @Route("/", name="home")
     */
    public function homePage() {
        $content = "<h1>Ceci est la HomePage</h1>";
        return new Response($content);
    }
}