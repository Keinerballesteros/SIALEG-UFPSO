<?php
namespace App\Controller\Api;

use App\Security\SialegUser;
use App\Service\MenuService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

#[Route('/api/auth')]
class AuthController extends AbstractController
{
    public function __construct(private MenuService $menu) {}

    #[Route('/login', methods: ['POST'])]
    public function login(#[CurrentUser] ?SialegUser $user): JsonResponse
    {
        return $this->payload($user);
    }

    #[Route('/me', methods: ['GET'])]
    public function me(#[CurrentUser] ?SialegUser $user): JsonResponse
    {
        return $this->payload($user);
    }

    private function payload(?SialegUser $user): JsonResponse
    {
        if (!$user) {
            return $this->json(['error' => 'no_autenticado'], 401);
        }
        return $this->json([
            'usuario' => [
                'documento' => $user->documento,
                'nombre'    => $user->nombre,
                'acceso'    => $user->acceso,
                'tipo'      => $user->tipo,
            ],
            'menu' => $this->menu->paraAcceso($user->acceso),
        ]);
    }
}
