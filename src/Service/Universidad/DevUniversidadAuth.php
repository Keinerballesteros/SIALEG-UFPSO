<?php
namespace App\Service\Universidad;

use App\Service\Universidad\UniversidadAuthInterface;

final class DevUniversidadAuth implements UniversidadAuthInterface
{
    public function __construct(private string $devPassword, private string $entorno) {}

    public function verificar(string $documento, string $password): bool
    {
        if ($this->entorno !== 'dev' || $this->devPassword === '') {
            return false;
        }
        return hash_equals($this->devPassword, $password);
    }
}
