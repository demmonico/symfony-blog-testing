<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class HealthCheckController extends AbstractController
{
    /**
     * @Route("/status")
     */
    public function status()
    {
        return new JsonResponse([
            "status" => "ok",
            "time"   => time(),
            "host"   => gethostname(),
        ]);
    }
}
