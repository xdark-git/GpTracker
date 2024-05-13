<?php
namespace App\Transformers\API\Role;

use App\Entity\Role;
use League\Fractal\TransformerAbstract;

class RoleTransformer extends TransformerAbstract
{
    public const ID = "id";
    public const NAME = "name";

    protected array $defaultIncludes = [];

    public function transform(Role $role): array
    {
        return [
            self::ID => $role->getId(),
            self::NAME => $role->getName(),
        ];
    }
}
