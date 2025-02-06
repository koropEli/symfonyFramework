<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Service\RegistrationService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;


class SecurityController extends AbstractController
{
    #[Route('/login', name: 'app_login', methods: ['POST'])]
    public function login(AuthenticationUtils $authenticationUtils, Request $request): JsonResponse
    {
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        if ($error) {
            return new JsonResponse([
                'message' => 'Invalid credentials',
                'last_username' => $lastUsername,
            ], JsonResponse::HTTP_UNAUTHORIZED);
        }

        return new JsonResponse([
            'message' => 'Login successful',
            'user' => $lastUsername,
        ]);
    }


    #[Route('/register', name: 'app_register', methods: ['POST'])]
    public function register(Request $request, RegistrationService $registrationService, SessionInterface $session): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $username = $data['username'] ?? null;
        $email = $data['email'] ?? null;
        $plainPassword = $data['password'] ?? null;

        if (empty($username) || empty($email) || empty($plainPassword)) {
            return new JsonResponse([
                'error' => true,
                'message' => 'Username, email, and password are required.'
            ], Response::HTTP_BAD_REQUEST);
        }

        try {
            $registrationService->register($username, $email, $plainPassword);
            $session->set('registered_username', $username);

            return new JsonResponse([
                'success' => true,
                'message' => 'Registration successful!'
            ], Response::HTTP_CREATED);
        } catch (\Exception $e) {
            return new JsonResponse([
                'error' => true,
                'message' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    #[Route('/logout', name: 'app_logout')]
    public function logout(): void
    {

    }
}
