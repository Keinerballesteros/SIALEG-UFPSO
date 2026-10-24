<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'ACCESO_MODULO')]
class AccesoModulo
{
    #[ORM\Id]
    #[ORM\ManyToOne(targetEntity: Acceso::class)]
    #[ORM\JoinColumn(name: 'ACCE_ID', referencedColumnName: 'ACCE_ID', nullable: false)]
    public Acceso $acceso;

    #[ORM\Id]
    #[ORM\ManyToOne(targetEntity: Modulo::class)]
    #[ORM\JoinColumn(name: 'MODU_ID', referencedColumnName: 'MODU_ID', nullable: false)]
    public Modulo $modulo;

    #[ORM\ManyToOne(targetEntity: Permiso::class)]
    #[ORM\JoinColumn(name: 'PERM_ID', referencedColumnName: 'PERM_ID', nullable: false)]
    public Permiso $permiso;
}
