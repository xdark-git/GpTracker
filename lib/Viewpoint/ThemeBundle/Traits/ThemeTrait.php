<?php

namespace Viewpoint\ThemeBundle\Traits;

use Viewpoint\ThemeBundle\Entity\Conveyance;

trait ThemeTrait{

    public function createConveyance(string $name): Conveyance
    {
        $conveyance = new Conveyance();
        $conveyance->setName($name);

        return $conveyance;
    }
}