<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;


#[ORM\Entity]
#[ORM\Table(name: 'TV_USUARIO_ADMINISTRATIVO_CON_PRERREGISTRO')]
class UsuarioAdministrativo
{
    #[ORM\Id]
    #[ORM\Column(name: 'UACP_CODIGOUNI', type: 'string', length: 7)]
    public string $codigoUni;

    #[ORM\ManyToOne(targetEntity: Acceso::class)]
    #[ORM\JoinColumn(name: 'ACCE_ID', referencedColumnName: 'ACCE_ID', nullable: false)]
    public Acceso $acceso;

    #[ORM\ManyToOne(targetEntity: TipoDocumento::class)]
    #[ORM\JoinColumn(name: 'TIDO_ID', referencedColumnName: 'TIDO_ID', nullable: false)]
    public TipoDocumento $tipoDocumento;

    #[ORM\Column(name: 'UACP_NRODI', type: 'string', length: 15, unique: true)]
    public string $nrodi;

    #[ORM\Column(name: 'UACP_APELLIDO1', type: 'string', length: 50)]
    public string $apellido1;

    #[ORM\Column(name: 'UACP_APELLIDO2', type: 'string', length: 50, nullable: true)]
    public ?string $apellido2 = null;

    #[ORM\Column(name: 'UACP_NOMBRE1', type: 'string', length: 50)]
    public string $nombre1;

    #[ORM\Column(name: 'UACP_NOMBRE2', type: 'string', length: 50, nullable: true)]
    public ?string $nombre2 = null;

    #[ORM\Column(name: 'UACP_CELULAR', type: 'string', length: 15, nullable: true)]
    public ?string $celular = null;

    #[ORM\Column(name: 'UACP_EMAIL', type: 'string', length: 320)]
    public string $email;
}
