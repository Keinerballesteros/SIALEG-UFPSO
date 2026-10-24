<?php
namespace App\Security;

use Symfony\Component\Security\Core\User\UserInterface;

final class SialegUser implements UserInterface
{
    public function __construct(
        public readonly string $documento,
        public readonly string $codigoUni,
        public readonly string $nombre,
        public readonly string $acceso,   // ADM, COO, SEC, ASE, PRA...
        public readonly string $tipo,     // ESTUDIANTE | ADMINISTRATIVO
    ) {}

    public function getUserIdentifier(): string { return $this->documento; }
    public function getRoles(): array { return ['ROLE_USER', 'ROLE_' . $this->acceso]; }
    public function eraseCredentials(): void {}
}
