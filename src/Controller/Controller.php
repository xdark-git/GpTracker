<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Log\AppLogger;


class Controller extends AbstractController
{
    protected AppLogger $logger;

    public function __construct()
    {
        // TODO : fix this 
        $this->logger = $this->container->get(AppLogger::class);
    }
}
