<?php

namespace App\Controller;

use App\Entity\Note;
use App\Entity\Upload;
use App\Repository\NoteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/note')]
class NoteController extends AbstractController
{
    private NoteRepository $noteRepository;

    public function __construct(NoteRepository $noteRepository)
    {
        $this->noteRepository = $noteRepository;
    }

    #[Route('', name: 'note_index', methods: ['GET'])]
    public function index(NoteRepository $noteRepository, SerializerInterface $serializer): JsonResponse
    {
        $notes = $noteRepository->findAll();
        $json = $serializer->serialize($notes, 'json', ['groups' => ['note']]);

        return new JsonResponse($json, 200, [], true);
    }

    #[Route('/create', name: 'note_create', methods: ['POST'])]
    #[IsGranted('ROLE_ADMIN')]
    public function create(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $note = new Note();
        $note->setTitle($data['title']);
        $note->setContent($data['content']);

        $entityManager->persist($note);
        $entityManager->flush();

        return $this->json($note);
    }

    #[Route('/{id}', name: 'note_show', methods: ['GET'])]
    public function show(Note $note, SerializerInterface $serializer): JsonResponse
    {
        $json = $serializer->serialize($note, 'json', ['groups' => ['note']]);

        return new JsonResponse($json, 200, [], true);
    }

    #[Route('/user/{userId}', name: 'notes_by_user', methods: ['GET'])]
    #[IsGranted('ROLE_ADMIN')]
    public function getNotesByUser(int $userId,  SerializerInterface $serializer): JsonResponse
    {
        $notes = $this->noteRepository->findByUser($userId);
        $json = $serializer->serialize($notes, 'json', ['groups' => ['note']]);
        return $this->json($json, 200, [], ['groups' => 'note:read']);
    }


    #[Route('/tag/{tagName}', name: 'notes_by_tag', methods: ['GET'])]
    public function getNotesByTag(string $tagName,  SerializerInterface $serializer): JsonResponse
    {
        $notes = $this->noteRepository->findByTag($tagName);
        $json = $serializer->serialize($notes, 'json', ['groups' => ['note']]);
        return $this->json($json, 200, [], ['groups' => 'note:read']);
    }

    #[Route('/latest/{limit}', name: 'latest_notes', methods: ['GET'])]
    public function getLatestNotes(SerializerInterface $serializer, int $limit = 10): JsonResponse
    {
        $notes = $this->noteRepository->findLatestNotes($limit);
        $json = $serializer->serialize($notes, 'json', ['groups' => ['note']]);
        return $this->json($json, 200, [], ['groups' => 'note:read']);
    }

    #[Route('/{id}', name: 'note_delete', methods: ['DELETE'])]
    #[IsGranted('ROLE_ADMIN')]
    public function delete(Note $note, EntityManagerInterface $entityManager): JsonResponse
    {
        $entityManager->remove($note);
        $entityManager->flush();

        return $this->json(['message' => 'Note deleted']);
    }
}
