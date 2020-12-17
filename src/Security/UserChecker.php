<?php 

namespace App\Security;

use App\Entity\User as AppUser;
use App\Exception\AccountDeletedException;
use Exception;
use JsonException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Security\Core\Exception\AccountExpiredException;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAccountStatusException;
use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class UserChecker implements UserCheckerInterface
{
    

    public function checkPreAuth(UserInterface $user)
    {
        return;
    }

    public function checkPostAuth(UserInterface $user)
    {
        if (!$user instanceof AppUser) {
            return;
        }

        // user account is expired, the user may be notified
        if (!$user->isVerified()) {
            throw new HttpException(Response::HTTP_UNAUTHORIZED,$user->getEmail() . " isn't verified");
        }
    }
}