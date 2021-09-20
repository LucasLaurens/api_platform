<?php

namespace App\Security;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\AbstractGuardAuthenticator;


class ApiKeyAuthenticator extends AbstractGuardAuthenticator
{
    public function start(Request $request, AuthenticationException $authException = null): Response
    {
        $data = [
            'message' => 'Authentication Required'
        ];

        return new JsonResponse($data, Response::HTTP_UNAUTHORIZED);
    }    

    public function supports(Request $request): ?bool
    {
        $auth = $request->headers->get('Authorization');

        return $auth && str_starts_with($auth, 'Bearer');
    }
    
    public function getCredentials(Request $request)
    {
        $token = str_replace('Bearer ', '', $request->headers->get('Authorization'));
        return [
            'apiKey' => $token
        ];
    }

    public function getUser($credentials, UserProviderInterface $userProvider): ?UserInterface
    {
        if (null === $credentials) {
            return null;
        }

        return $userProvider->loadUserByIdentifier($credentials['apiKey']);
    }

    public function checkCredentials($credentials, UserInterface $user): bool
    {
        return $user instanceof User && $credentials['apiKey'] === $user->getApiKey();
    }   
    
    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): ?Response
    {
        $data = [
            'message' => strtr($exception->getMessageKey(), $exception->getMessageData())
        ];
        
        return new JsonResponse($data, Response::HTTP_FORBIDDEN);
    }
   
    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        return null;
    }
    public function supportsRememberMe(): bool
    {
        return false;
    }
   
}
