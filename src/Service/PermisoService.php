<?php
namespace App\Service;

use App\Security\SialegUser;
use Doctrine\DBAL\Connection;
use App\Service\NivelPermiso;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;


final class PermisoService
{
    public function __construct(private Connection $db) {}

    public function tiene(SialegUser $u, string $modulo, int $bit): bool
    {
        $nivel = (int) $this->db->fetchOne(
            'SELECT PERM_ID FROM ACCESO_MODULO WHERE ACCE_ID = :a AND MODU_ID = :m',
            ['a' => $u->acceso, 'm' => $modulo]
        );
        return NivelPermiso::incluye($nivel, $bit);
    }

    public function exigir(SialegUser $u, string $modulo, int $bit): void
    {
        if (!$this->tiene($u, $modulo, $bit)) {
            throw new AccessDeniedHttpException('No tienes permiso para esta acción.');
        }
    }
}
