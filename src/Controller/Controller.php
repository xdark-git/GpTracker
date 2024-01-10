<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Log\AppLogger;
use Psr\Log\LoggerInterface;
use Symfony\Contracts\Service\Attribute\Required;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use League\Fractal\Manager as FractalManager;
use League\Fractal\TransformerAbstract;
use App\Service\Helpers;
use League\Fractal\Resource\Item;
use App\Transformers\Serializers\ArraySerializer;
use Symfony\Component\Security\Core\User\UserInterface;
use LoginUserNotVerifiedException;

class Controller extends AbstractController
{
    // TODO: use AppLogger when configured
    // protected AppLogger $logger;
    protected LoggerInterface $logger;
    protected FractalManager $fractalManager;

    public function __construct()
    {
    }

    protected function successResponse(
        string $message,
        int $statusCode = Response::HTTP_OK
    ): JsonResponse {
        return new JsonResponse(["message" => $message], $statusCode);
    }

    protected function arrayResponse(array $data): JsonResponse
    {
        return new JsonResponse($data, Response::HTTP_OK);
    }

    protected function errorResponse(
        string $message,
        int $statusCode = Response::HTTP_INTERNAL_SERVER_ERROR
    ): JsonResponse {
        return new JsonResponse(
            [
                "message" => $message,
            ],
            $statusCode
        );
    }

    protected function itemResponse(object $item, TransformerAbstract $transformer): JsonResponse
    {
        $this->parseGetIncludes();

        return new JsonResponse($this->transformItem($item, $transformer), Response::HTTP_OK);
    }

    private function parseGetIncludes(): void
    {
        // we avoid erasing any previous set includes in controller, we save them in tmp variable
        $requestedIncludes = $this->fractalManager->getRequestedIncludes();
        $this->fractalManager->parseIncludes((string) Helpers::arrayGet($_GET, "include", ""));

        // merge back old includes
        $this->fractalManager->parseIncludes(
            array_merge($requestedIncludes, $this->fractalManager->getRequestedIncludes())
        );
    }

    protected function transformItem(object $item, TransformerAbstract $transformer): array
    {
        $this->parseGetIncludes();

        $fractalResource = new Item($item, $transformer);

        return $this->fractalManager->createData($fractalResource)->toArray();
    }

    /**
     * @param bool $isVerificationFromApi
     * @throws LoginUserNotVerifiedException
     */
    public function assertLoginUserVerified(bool $isVerificationFromApi = true): void
    {
        /** @var User $user */
        $user = $this->getUser();

        if (!$user instanceof UserInterface) {
            return;
        }

        $userIsVerified = $user->getIsVerified();

        if ($userIsVerified) {
            return;
        }

        if (!$userIsVerified && $isVerificationFromApi) {
            throw new LoginUserNotVerifiedException("User is not verified");
        }

        $this->redirectToRoute("non_verified_user_page");
    }

    #[Required]
    public function setLogger(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    #[Required]
    public function setFractalManager(
        FractalManager $fractalManager,
        ArraySerializer $arraySerializer
    ) {
        $this->fractalManager = $fractalManager;
        $this->fractalManager->setSerializer($arraySerializer);
        $this->fractalManager->setRecursionLimit(15);
    }
}
