<?php

namespace Viewpoint\AdminBundle\Validator;

use Symfony\Component\Validator\Attribute\HasNamedArguments;
use Symfony\Component\Validator\Constraint;

#[\Attribute]
class UniqueEmail extends Constraint
{
    public string $message = 'L\'e-mail "{{ string }}" existe déjà';

    #[HasNamedArguments]
    public function __construct(
        public string $mode,
        array $groups = null,
        mixed $payload = null,
    ) {
        parent::__construct([], $groups, $payload);
    }
}
