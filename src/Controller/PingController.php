<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

class PingController extends AbstractController
{
    #[Route('/api/ping', methods: ['GET'])]
    public function __invoke(): JsonResponse
    {
        return $this->json(['mensaje' => 'Symfony funcionando']);
    }
}
