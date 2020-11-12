<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;

class HomeController {

    public function homePage() {
        $content = "<h1>Ceci est la HomePage</h1>";
        return new Response($content);
    }
}