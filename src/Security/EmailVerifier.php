<?php

namespace App\Security;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Encoder\JWTEncoderInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;
use SymfonyCasts\Bundle\VerifyEmail\VerifyEmailHelperInterface;

class EmailVerifier
{
    private $verifyEmailHelper;
    private $mailer;
    private $entityManager;
    private $jwtEncoder;
  

    public function __construct(VerifyEmailHelperInterface $helper, MailerInterface $mailer, EntityManagerInterface $manager,  JWTEncoderInterface $JWTencoder)
    {
        $this->verifyEmailHelper = $helper;
        $this->mailer = $mailer;
        $this->entityManager = $manager;
        $this->jwtEncoder = $JWTencoder;
    }

    public function sendEmailConfirmation(string $verifyEmailRouteName, UserInterface $user,  TemplatedEmail $email): void
    {
        $userJwt = $this->jwtEncoder->encode(["mail" => $user->getEmail(), "id" => $user->getId()]);

        $signatureComponents = $this->verifyEmailHelper->generateSignature(
            $verifyEmailRouteName,
            $user->getId(),
            $user->getEmail(),
            ["authToken" => $userJwt]
        );

        $context = $email->getContext();
        $context['signedUrl'] = $signatureComponents->getSignedUrl();
        $context['expiresAt'] = $signatureComponents->getExpiresAt();

        $email->context($context);

        $this->mailer->send($email);
    }

    /**
     * @param Request $request
     * @param string $authToken
     * 
     * @throws VerifyEmailExceptionInterface
     */
    public function handleEmailConfirmation(Request $request, string $authToken): void
    {
        //Retrieve credentials from token
        $userData = $this->jwtEncoder->decode($authToken);

        //Find user thanks to credentials
        $user = $this->entityManager->find(User::class,$userData["id"]);

        if(!$user) {
            throw new VerifyEmailExceptionInterface("User doesn't found");
        }
        
        $this->verifyEmailHelper->validateEmailConfirmation($request->getUri(), $user->getId(), $user->getEmail());

        $user->setIsVerified(true);

        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }
}
