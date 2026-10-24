<?php
namespace App\Controller\Api;

use App\Entity\UsuarioAdministrativo;
use App\Entity\UsuarioEstudiante;
use App\Security\SialegUser;
use App\Service\NivelPermiso;
use App\Service\PermisoService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

#[Route('/api/perfil')]
class PerfilController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $em,
        private PermisoService $permisos,
    ) {}

    #[Route('', methods: ['GET'])]
    public function __invoke(#[CurrentUser] SialegUser $user): JsonResponse
    {
        $this->permisos->exigir($user, 'PERFIL', NivelPermiso::VER);

        // El perfil siempre es el del usuario en sesión: nunca se recibe un id por la URL
        $u = $user->tipo === 'ESTUDIANTE'
            ? $this->em->find(UsuarioEstudiante::class, $user->codigoUni)
            : $this->em->find(UsuarioAdministrativo::class, $user->codigoUni);

        if (!$u) {
            throw $this->createNotFoundException('No se encontró el usuario.');
        }

        $nombre = trim(implode(' ', array_filter([
            $u->nombre1, $u->nombre2, $u->apellido1, $u->apellido2,
        ])));

        return $this->json([
            'nombre'         => $nombre,
            'cargo'          => $u->acceso->nombre,   // Director, Estudiante, Secretaria...
            'documento'      => $u->nrodi,
            'codigo'         => $u->codigoUni,
            'email'          => $u->email,
            'celular'        => $u->celular,
            'casosEnTramite' => null,                 // se llenará cuando exista el módulo de casos
        ]);
    }
}
