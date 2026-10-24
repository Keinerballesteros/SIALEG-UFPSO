<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'TVM_TIPO_DOCUMENTO')]
class TipoDocumento
{
    #[ORM\Id]
    #[ORM\Column(name: 'TIDO_ID', type: 'string', length: 3)]
    public string $id;

    #[ORM\Column(name: 'TIDO_NOMBRE', type: 'string', length: 50)]
    public string $nombre;
}
