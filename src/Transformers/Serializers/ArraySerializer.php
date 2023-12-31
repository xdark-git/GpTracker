<?php

namespace App\Transformers\Serializers;

use League\Fractal\Serializer\ArraySerializer as FractalArraySerializer;

class ArraySerializer extends FractalArraySerializer
{
    public function collection(?string $resourceKey, array $data): array
    {
        return $data;
    }
}
