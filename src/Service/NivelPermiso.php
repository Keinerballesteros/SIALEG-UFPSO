<?php
namespace App\Service;

final class NivelPermiso
{
    public const ELIMINAR = 1;
    public const EDITAR   = 2;
    public const VER      = 4;
    public const AGREGAR  = 8;

    public static function incluye(int $nivel, int $accion): bool
    {
        return ($nivel & $accion) === $accion;
    }
}
