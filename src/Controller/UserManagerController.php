<?php

namespace App\Controller;

use App\Repository\UserRepository;
use App\Service\Serializer\UserNormalizer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;


class UserManagerController extends AbstractController {

    /**
     * @Route("/api/admin/users/{page}", name="app_get_users", methods={"GET"})
     */
    public function getUsersByPage ($page = 0,UserRepository $userRepository, UserNormalizer $userNormalizer) {
        
        $this->denyAccessUnlessGranted(ROLE_ADMIN);
        $users = $userRepository->findByPage($page);
        $maxUsers = $userRepository->getUserQuantity();
        $maxPage = ceil( $maxUsers / MAX_USER_LIST_SIZE );

        
        $serializer = new Serializer([$userNormalizer], [new JsonEncoder()]);

        $data = $serializer->serialize( ["users" => $users,  "maxPage" => $maxPage, "currentPage" => $page ], 'json');
        
        return new JsonResponse($data, HTTP_SUCCESS);
    }
    
}