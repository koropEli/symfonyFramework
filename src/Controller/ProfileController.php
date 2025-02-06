<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class ProfileController extends AbstractController
{
    #[Route('/profile', name: 'profile', methods: ['GET'])]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function index(SerializerInterface $serializer): JsonResponse
    {
        $user = $this->getUser();

        if (!$user) {
            return $this->redirectToRoute('error', ['statusCode' => 400, 'message' => 'Firmware not found.']);
        }

        $userData = $serializer->serialize($user, 'json', ['groups' => ['user:read']]);

        return new JsonResponse($userData, Response::HTTP_OK, [], true);
    }

}
