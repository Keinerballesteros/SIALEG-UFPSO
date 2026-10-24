<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;


#[ORM\Entity]
#[ORM\Table(name: 'TV_USUARIO_ESTUDIANTE_CON_PRERREGISTRO')]
class UsuarioEstudiante
{
    #[ORM\Id]
    #[ORM\Column(name: 'UECP_CODIGOUNI', type: 'string', length: 7)]
    public string $codigoUni;

    #[ORM\ManyToOne(targetEntity: Acceso::class)]
    #[ORM\JoinColumn(name: 'ACCE_ID', referencedColumnName: 'ACCE_ID', nullable: false)]
    public Acceso $acceso;

    #[ORM\ManyToOne(targetEntity: TipoDocumento::class)]
    #[ORM\JoinColumn(name: 'TIDO_ID', referencedColumnName: 'TIDO_ID', nullable: false)]
    public TipoDocumento $tipoDocumento;

    #[ORM\Column(name: 'UECP_NRODI', type: 'string', length: 15, unique: true)]
    public string $nrodi;

    #[ORM\Column(name: 'UECP_APELLIDO1', type: 'string', length: 50)]
    public string $apellido1;

    #[ORM\Column(name: 'UECP_APELLIDO2', type: 'string', length: 50, nullable: true)]
    public ?string $apellido2 = null;

    #[ORM\Column(name: 'UECP_NOMBRE1', type: 'string', length: 50)]
    public string $nombre1;

    #[ORM\Column(name: 'UECP_NOMBRE2', type: 'string', length: 50, nullable: true)]
    public ?string $nombre2 = null;

    #[ORM\Column(name: 'UECP_CELULAR', type: 'string', length: 15, nullable: true)]
    public ?string $semestrecurs = null;

    #[ORM\Column(name: 'UECP_EMAIL', type: 'string', length: 320)]
    public string $email;

    #[ORM\Column(name: 'UECP_SEMESTRECURS', type: 'string', length: 15, nullable: true)]
    public ?string $celular = null;

    #[ORM\ManyToOne(targetEntity: Rol::class)]
    #[ORM\JoinColumn(name: 'ROL_ID', referencedColumnName: 'ROL_ID', nullable: false)]
    public Rol $rol;
}
