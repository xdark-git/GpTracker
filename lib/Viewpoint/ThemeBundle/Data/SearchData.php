<?php

namespace Viewpoint\ThemeBundle\Data;

class SearchData
{
    public ?string $departureLocation = null;

    public ?string $arrivalLocation = null;

    public ?\DateTime $minDate = null;

    public ?\DateTime $maxDate = null;
}