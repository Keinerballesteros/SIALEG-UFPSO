<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;


#[ORM\Entity]
#[ORM\Table(name: 'TVM_ACCESO')]
class Acceso
{
    #[ORM\Id]
    #[ORM\Column(name: 'ACCE_ID', type: 'string', length: 3)]
    public string $id;

    #[ORM\Column(name: 'ACCE_NOMBRE', type: 'string', length: 50)]
    public string $nombre;
}
