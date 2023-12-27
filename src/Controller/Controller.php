<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Log\AppLogger;
use Psr\Log\LoggerInterface;
use Symfony\Contracts\Service\Attribute\Required;

class Controller extends AbstractController
{
    // TODO: use AppLogger when configured
    // protected AppLogger $logger;
    protected LoggerInterface $logger;

    public function __construct()
    {
    }

    #[Required]
    public function setLogger(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }
}
