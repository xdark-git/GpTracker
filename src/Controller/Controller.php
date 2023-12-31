<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Log\AppLogger;
use Psr\Log\LoggerInterface;
use Symfony\Contracts\Service\Attribute\Required;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use League\Fractal\Manager as FractalManager;
use League\Fractal\TransformerAbstract;
use App\Http\Transformers\Serializers\ArraySerializer;
use League\Fractal\Resource\Item;

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
        $this->fractalManager->parseIncludes(
            (string) array_key_exists("include", $_GET) ? $_GET["include"] : ""
        );

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

    #[Required]
    public function setLogger(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    #[Required]
    public function setFractalManager(FractalManager $fractalManager)
    {
        $this->fractalManager = $fractalManager;
        // TODO: fix this
        // $this->fractalManager->setSerializer($this->container->get(ArraySerializer::class));
        // $this->fractalManager->setRecursionLimit(15);
    }
}
