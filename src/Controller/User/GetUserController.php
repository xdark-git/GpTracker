<?php

namespace App\Controller\User;

use App\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\User\UserService;

class GetUserController extends Controller
{
    public function __construct(
        private readonly UserService $userService,
    )
    {
        parent::__construct();
    }
    
    #[Route('/api/user', name: 'app_get_user')]
    public function index(): Response
    {
        try {
            $this->logger->info('User found');
            $user = $this->userService->findById(1);

            return $this->json([
                'message' => 'User found',
                'user' => $user,
            ]);
        } catch (\Throwable $th) {

            return $this->json([
                'message' => 'User not found',
                'error' => $th->getMessage(),
            ], 404);
        }
    }
}
