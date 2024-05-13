<?php

namespace App\Controller\User;

use App\Controller\Controller;
use App\Entity\User;
use App\Log\LogParameterList;
use App\Service\Feature\FeatureList;
use Symfony\Component\HttpFoundation\Response;
use App\Service\User\UserService;
use Throwable;
use App\Transformers\API\User\UserTransformer;

class ShowUserController extends Controller
{
    public function __construct(
        private readonly UserService $userService,
        private readonly UserTransformer $userTransformer
    ) {
        parent::__construct();
    }

    public function __invoke(int $id): Response
    {
        try {
            $user = $this->userService->findById($id);
            
            if (!$user instanceof User) {
                return $this->errorResponse("User not found", Response::HTTP_NOT_FOUND);
            }

            return $this->itemResponse($user, $this->userTransformer);
        } catch (Throwable $th) {
            $this->logger->error("an error occurred while getting the user ", [
                LogParameterList::FEATURE       => FeatureList::USER,
                LogParameterList::ERROR_MESSAGE => $th->getMessage(),
                LogParameterList::ERROR_TRACE   => $th->getTraceAsString(),
                LogParameterList::EXTRA         => [
                    'user.id' => $id
                ]
            ]);

            return $this->errorResponse(
                "an error occurred while getting the user ",
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }
}
