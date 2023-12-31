<?php
namespace App\Transformers\API\User;

use App\Entity\User;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
{
    public const ID             = "id";
    public const FIRST_NAME     = "first_name";
    public const LAST_NAME      = "last_name";
    public const EMAIL          = "email";
    public const IS_VERIFIED    = "is_verified";
    public const FULL_NAME      = "full_name";
    
    public function transform(User $user): array
    {
        return [
            self::ID => $user->getId(),
            self::FIRST_NAME => $user->getFirstName(),
            self::LAST_NAME => $user->getLastName(),
            self::EMAIL => $user->getEmail(),
            self::IS_VERIFIED => $user->getIsVerified(),
        ];
    }
}