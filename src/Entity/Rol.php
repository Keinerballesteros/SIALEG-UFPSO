<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'TVM_ROL')]
class Rol
{
    #[ORM\Id]
    #[ORM\Column(name: 'ROL_ID', type: 'string', length: 2)]
    public string $id;

    #[ORM\Column(name: 'ROL_DESCRIPCION', type: 'string', length: 100)]
    public string $descripcion;

    #[ORM\Column(name: 'ROL_CODIGO', type: 'string', length: 30)]
    public string $codigo;
}
