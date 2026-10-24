<?php

namespace App\Service;

use Doctrine\DBAL\Connection;

final class MenuService
{
    public function __construct(private Connection $db) {}

    public function paraAcceso(string $acce): array
    {
        $rows = $this->db->fetchAllAssociative(
            "SELECT m.MODU_ID, m.MODU_DESCRIPCION, m.MODU_URL, m.MODU_ICONCARACTER, am.PERM_ID
               FROM ACCESO_MODULO am
               JOIN TVM_MODULO m ON m.MODU_ID = am.MODU_ID
              WHERE am.ACCE_ID = :a AND am.PERM_ID <> '0'
              ORDER BY m.MODU_ORDEN",
            ['a' => $acce]
        );

        return array_map(function ($r) {
            $n = (int) $r['PERM_ID'];
            return [
                'id'      => $r['MODU_ID'],
                'nombre'  => $r['MODU_DESCRIPCION'],
                'ruta'    => $r['MODU_URL'],
                'icono'   => $r['MODU_ICONCARACTER'],
                'permiso' => $n,
                'puede'   => [
                    'ver'      => NivelPermiso::incluye($n, NivelPermiso::VER),
                    'agregar'  => NivelPermiso::incluye($n, NivelPermiso::AGREGAR),
                    'editar'   => NivelPermiso::incluye($n, NivelPermiso::EDITAR),
                    'eliminar' => NivelPermiso::incluye($n, NivelPermiso::ELIMINAR),
                ],
            ];
        }, $rows);
    }
}
