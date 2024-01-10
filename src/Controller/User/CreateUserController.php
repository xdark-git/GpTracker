<?php

namespace App\Controller\User;

use App\Controller\Controller;
use App\Entity\User;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\User\UserService;
use Throwable;
use App\Transformers\API\User\UserTransformer;

class CreateUserController extends Controller
{
    public function __construct(
        private readonly UserService $userService, 
        private readonly UserTransformer $userTransformer
    )
    {
        parent::__construct();
    }

    public function __invoke(): Response
    {
        try {
            $this->logger->warning("User found");
            $user = $this->userService->findById(1);

            if (!$user instanceof User) {
                return $this->errorResponse(
                    "User not found",
                    Response::HTTP_NOT_FOUND
                );
            }

            return $this->itemResponse($user, $this->userTransformer);
        } catch (Throwable $th) {
            $this->logger->error("an error occurred while getting the user ", [
                "error" => $th->getMessage(),
                "line" => $th->getLine(),
                "file" => $th->getFile(),
            ]);

            return $this->errorResponse(
                "an error occurred while getting the user ",
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }
}
