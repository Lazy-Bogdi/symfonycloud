<?php

// declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\User;
use App\Repository\UserRepository;

#[Route('/api/admin/users')]
#[IsGranted('ROLE_ADMIN')]
class AdminController extends AbstractController
{
    private SerializerInterface $serializer;
    private EntityManagerInterface $entityManager;
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(SerializerInterface $serializer, EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher)
    {
        $this->serializer = $serializer;
        $this->entityManager = $entityManager;
        $this->passwordHasher = $passwordHasher;
    }

    #[Route('', name: 'user_create', methods: ['POST'])]
    public function create(Request $request): Response
    {
        $user = $this->serializer->deserialize($request->getContent(), User::class, 'json');

        // Hash the password
        $user->setPassword($this->passwordHasher->hashPassword($user, $user->getPassword()));

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return $this->json($user, Response::HTTP_CREATED, [], ['groups' => 'user:read']);

    }

    #[Route('/{id}', name: 'user_read', methods: ['GET'])]
    public function read(User $user): Response
    {
        return $this->json($user, Response::HTTP_OK, [], ['groups' => 'user:read']);

    }

    #[Route('', name: 'user_list', methods: ['GET'])]
    public function list(UserRepository $userRepository): Response
    {
        $users = $userRepository->findAll();
        return $this->json($users, Response::HTTP_OK, [], ['groups' => 'user:list']);

    }


    #[Route('/{id}', name: 'user_update', methods: ['PUT'])]
    public function update(Request $request, User $user): Response
    {
        $this->serializer->deserialize($request->getContent(), User::class, 'json', ['object_to_populate' => $user]);

        // If password needs to be updated
        if ($request->get('password')) {
            $user->setPassword($this->passwordHasher->hashPassword($user, $request->get('password')));
        }

        $this->entityManager->flush();

        return $this->json($user, Response::HTTP_OK, [], ['groups' => 'user:read']);

    }

    #[Route('/{id}', name: 'user_delete', methods: ['DELETE'])]
    public function delete(User $user): Response
    {
        $this->entityManager->remove($user);
        $this->entityManager->flush();

        return $this->json(null, Response::HTTP_NO_CONTENT);
    }
}
