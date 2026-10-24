<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20261013023802 extends AbstractMigration
{
    public function up(Schema $schema): void
{
    // Tipos de documento y rol de estudiante (ajusta el rol cuando sepas qué valores usa la universidad)
    $this->addSql("INSERT INTO TVM_TIPO_DOCUMENTO (TIDO_ID, TIDO_NOMBRE) VALUES ('CC', 'Cédula de ciudadanía')");
    $this->addSql("INSERT INTO TVM_ROL (ROL_ID, ROL_DESCRIPCION, ROL_CODIGO) VALUES ('01', 'Estudiante practicante', 'PRACTICANTE')");

    // Tipos de acceso
    foreach ([
        ['ADM', 'Administrador'], ['COO', 'Coordinador'], ['SEC', 'Secretaria'],
        ['ASE', 'Asesor'], ['PRA', 'Practicante']
    ] as [$id, $nombre]) {
        $this->addSql("INSERT INTO TVM_ACCESO (ACCE_ID, ACCE_NOMBRE) VALUES ('$id', '$nombre')");
    }

    // Permisos estilo Linux: 4 = ver, 2 = editar, 1 = eliminar (se suman)
    foreach ([['0', 'Sin acceso'], ['4', 'Solo ver'], ['6', 'Ver y editar'], ['7', 'Control total']] as [$id, $desc]) {
        $this->addSql("INSERT INTO TVM_PERMISO (PERM_ID, PERM_DESCRIPCION) VALUES ('$id', '$desc')");
    }

    // Módulos (la ruta debe coincidir con las rutas de React en app.jsx)
    foreach ([
        ['PERFIL',        'Perfil',             '/perfil',             'user',     1],
        ['DASHBOARD',     'Dashboard',          '/dashboard',          'chart',    2],
        ['CASO_NUEVO',    'Agregar nuevo caso', '/casos/nuevo',        'plus',     3],
        ['ESTUDIANTES',   'Ver estudiante',     '/estudiantes',        'users',    4],
        ['CASO_CONSULTA', 'Consultar caso',     '/casos/consulta',     'search',   5],
        ['ENTREVISTA',    'Nueva entrevista',   '/entrevistas/nueva',  'mic',      6],
        ['MIS_CASOS',     'Casos',              '/casos',              'folder',   7],
        ['AUDIENCIAS',    'Audiencias',         '/audiencias',         'calendar', 8],
        ['CONCILIACION',  'Conciliaciones',     '/conciliaciones',     'handshake', 9],
    ] as [$id, $desc, $url, $icono, $orden]) {
        $this->addSql("INSERT INTO TVM_MODULO (MODU_ID, MODU_DESCRIPCION, MODU_URL, MODU_ICONCARACTER, MODU_ORDEN) VALUES ('$id', '$desc', '$url', '$icono', $orden)");
    }

    // Qué ve y qué puede hacer cada acceso en cada módulo
    foreach ([
        ['COO', 'PERFIL', '6'], ['COO', 'DASHBOARD', '4'], ['COO', 'CASO_NUEVO', '6'],
        ['COO', 'ESTUDIANTES', '4'], ['COO', 'CASO_CONSULTA', '6'],
        ['SEC', 'PERFIL', '6'], ['SEC', 'ESTUDIANTES', '4'], ['SEC', 'CASO_CONSULTA', '4'],
        ['PRA', 'ENTREVISTA', '6'], ['PRA', 'MIS_CASOS', '6'],
        ['PRA', 'AUDIENCIAS', '6'], ['PRA', 'CONCILIACION', '6'],
    ] as [$acce, $modu, $perm]) {
        $this->addSql("INSERT INTO ACCESO_MODULO (ACCE_ID, MODU_ID, PERM_ID) VALUES ('$acce', '$modu', '$perm')");
    }
}
}
