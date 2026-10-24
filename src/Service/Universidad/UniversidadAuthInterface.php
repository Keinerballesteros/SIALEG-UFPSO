<?php
namespace App\Service\Universidad;

interface UniversidadAuthInterface
{
    public function verificar(string $documento, string $password): bool;
}
