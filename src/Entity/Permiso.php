<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'TVM_PERMISO')]
class Permiso
{
    #[ORM\Id]
    #[ORM\Column(name: 'PERM_ID', type: 'string', length: 2)]
    public string $id;

    #[ORM\Column(name: 'PERM_DESCRIPCION', type: 'string', length: 15)]
    public string $descripcion;
}
