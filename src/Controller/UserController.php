<?php

namespace App\Controller;

use App\Entity\User;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UserController extends AbstractController {

    public function subscribe (Request $request, ValidatorInterface $validator) : Response {
        $data = $request->getContent();
        $formated = json_decode($data);

        $user = new User();
        $user
        ->setLastname($formated->lastname)
        ->setFirstname($formated->firstname)
        ->setUsername($formated->username)
        ->setEmail($formated->mail)
        ->setPassword($formated->password)
        ->setCreatedAt(new DateTime());

        $errors = $validator->validate($user);
    
        if(count($errors) === 0 ) {
           
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            
            return new Response("User Created");
        }
        
        return new Response("Error during subscription");
        
    }

}