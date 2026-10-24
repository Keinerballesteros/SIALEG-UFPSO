<?php
namespace App\Security;

use App\Entity\UsuarioAdministrativo;
use App\Entity\UsuarioEstudiante;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Exception\UserNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

final class UsuarioProvider implements UserProviderInterface
{
    public function __construct(private EntityManagerInterface $em) {}

    public function loadUserByIdentifier(string $identifier): UserInterface
    {
        $est = $this->em->getRepository(UsuarioEstudiante::class)->findOneBy(['nrodi' => $identifier]);
        if ($est) {
            return new SialegUser($est->nrodi, $est->codigoUni,
                trim("$est->nombre1 $est->apellido1"), $est->acceso->id, 'ESTUDIANTE');
        }

        $adm = $this->em->getRepository(UsuarioAdministrativo::class)->findOneBy(['nrodi' => $identifier]);
        if ($adm) {
            return new SialegUser($adm->nrodi, $adm->codigoUni,
                trim("$adm->nombre1 $adm->apellido1"), $adm->acceso->id, 'ADMINISTRATIVO');
        }

        throw new UserNotFoundException();
    }

    public function refreshUser(UserInterface $user): UserInterface
    {
        return $this->loadUserByIdentifier($user->getUserIdentifier());
    }

    public function supportsClass(string $class): bool
    {
        return $class === SialegUser::class;
    }
}
