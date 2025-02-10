<?php

namespace App\Controller;

use App\Entity\Tag;
use App\Repository\TagRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/tag')]
class TagController extends AbstractController
{
    #[Route('', name: 'tag_index', methods: ['GET'])]
    public function index(TagRepository $tagRepository, SerializerInterface $serializer): JsonResponse
    {
        $tags = $tagRepository->findAll();
        $json = $serializer->serialize($tags, 'json', ['groups' => ['tag']]);

        return new JsonResponse($json, 200, [], true);
    }

    #[Route('/create', name: 'tag_create', methods: ['POST'])]
    #[IsGranted('ROLE_ADMIN')]
    public function create(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $tag = new Tag();
        $tag->setName($data['name']);

        $entityManager->persist($tag);
        $entityManager->flush();

        return $this->json($tag);
    }

    #[Route('/{id}', name: 'tag_show', methods: ['GET'])]
    public function show(Tag $tag): JsonResponse
    {
        return $this->json($tag);
    }

    #[Route('/{id}', name: 'tag_delete', methods: ['DELETE'])]
    #[IsGranted('ROLE_ADMIN')]
    public function delete(Tag $tag, EntityManagerInterface $entityManager): JsonResponse
    {
        $entityManager->remove($tag);
        $entityManager->flush();

        return $this->json(['message' => 'Tag deleted']);
    }
}
