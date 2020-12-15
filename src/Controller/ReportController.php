<?php 

namespace App\Controller;

use App\Repository\CustomerFeelingsRepository;
use App\Service\Serializer\CustomerFeelingsNormalizer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Serializer;

class ReportController extends AbstractController {

    /**
     * @Route("/api/auth/report/{sessionId}")
     */
    public function getSessionReport (int $sessionId, CustomerFeelingsRepository $customerFeelingsRepository, CustomerFeelingsNormalizer $customerFeelingsNormalizer) {

        $this->denyAccessUnlessGranted("ROLE_ADMIN");

        $sessionWithNotations = $customerFeelingsRepository->getCustomerFeelingsFromOneSession($sessionId);
        
        
        $serializer = new Serializer([$customerFeelingsNormalizer, new DateTimeNormalizer()], [new JsonEncoder()]);

        $res = $serializer->serialize($sessionWithNotations, "json");
        
        return new JsonResponse($res);
    }

}