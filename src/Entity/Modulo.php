<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'TVM_MODULO')]
class Modulo
{
    #[ORM\Id]
    #[ORM\Column(name: 'MODU_ID', type: 'string', length: 15)]
    public string $id;

    #[ORM\Column(name: 'MODU_DESCRIPCION', type: 'string', length: 100)]
    public string $descripcion;

    #[ORM\Column(name: 'MODU_URL', type: 'string', length: 2083)]
    public string $url;

    #[ORM\Column(name: 'MODU_ICONCARACTER', type: 'string', length: 100)]
    public string $icono;

    #[ORM\Column(name: 'MODU_ORDEN', type: 'integer')]
    public int $orden;
}
