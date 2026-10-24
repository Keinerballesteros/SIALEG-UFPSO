<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20261024024017 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

public function up(Schema $schema): void
{
    // 1. PERM_ID a 2 caracteres (se necesita el valor '15'). Primero la tabla padre y luego la hija.
    $this->addSql('ALTER TABLE TVM_PERMISO MODIFY (PERM_ID VARCHAR2(2))');
    $this->addSql('ALTER TABLE ACCESO_MODULO MODIFY (PERM_ID VARCHAR2(2))');

    // 2. Se borra la matriz anterior y los módulos que ya no existen
    $this->addSql('DELETE FROM ACCESO_MODULO');
    $this->addSql("DELETE FROM TVM_MODULO WHERE MODU_ID IN
        ('DASHBOARD','CASO_NUEVO','CASO_CONSULTA','ENTREVISTA','MIS_CASOS','CONCILIACION')");

    // 3. Nombres de los accesos (los códigos no cambian)
    foreach ([
        ['ADM', 'Administrativo'], ['COO', 'Director'], ['ASE', 'Asesor (Profesor)'],
        ['PRA', 'Estudiante'], ['SEC', 'Secretaria'],
    ] as [$id, $nombre]) {
        $this->addSql("UPDATE TVM_ACCESO SET ACCE_NOMBRE = '$nombre' WHERE ACCE_ID = '$id'");
    }

    // 4. Permisos: ver = 4, editar = 2, eliminar = 1, agregar = 8 (se suman)
    //    (la descripción admite 15 caracteres)
    $this->addSql("UPDATE TVM_PERMISO SET PERM_DESCRIPCION = 'Solo ver'     WHERE PERM_ID = '4'");
    $this->addSql("UPDATE TVM_PERMISO SET PERM_DESCRIPCION = 'Ver y editar' WHERE PERM_ID = '6'");
    $this->addSql("UPDATE TVM_PERMISO SET PERM_DESCRIPCION = 'Sin agregar'  WHERE PERM_ID = '7'");
    $this->addSql("INSERT INTO TVM_PERMISO (PERM_ID, PERM_DESCRIPCION) VALUES ('15', 'Todos')");

    // 5. Módulos: los que ya existían se actualizan y los demás se crean
    $this->addSql("UPDATE TVM_MODULO SET MODU_DESCRIPCION = 'Perfil', MODU_URL = '/perfil',
        MODU_ICONCARACTER = 'user', MODU_ORDEN = 1 WHERE MODU_ID = 'PERFIL'");
    $this->addSql("UPDATE TVM_MODULO SET MODU_DESCRIPCION = 'Audiencias', MODU_URL = '/audiencias',
        MODU_ICONCARACTER = 'gavel', MODU_ORDEN = 6 WHERE MODU_ID = 'AUDIENCIAS'");
    $this->addSql("UPDATE TVM_MODULO SET MODU_DESCRIPCION = 'Estudiantes', MODU_URL = '/estudiantes',
        MODU_ICONCARACTER = 'users', MODU_ORDEN = 9 WHERE MODU_ID = 'ESTUDIANTES'");

    foreach ([
        ['SOLICITANTES', 'Solicitantes', '/solicitantes', 'users',     2],
        ['CONSULTAS',    'Consultas',    '/consultas',    'clipboard', 3],
        ['ENTREVISTAS',  'Entrevistas',  '/entrevistas',  'clipboard', 4],
        ['CASOS',        'Casos',        '/casos',        'folder',    5],
        ['PERSONAL',     'Personal',     '/personal',     'user-cog',  7],
        ['ESTADISTICAS', 'Estadísticas', '/estadisticas', 'chart',     8],
        ['PROFESORES',   'Profesores',   '/profesores',   'users',    10],
    ] as [$id, $desc, $url, $icono, $orden]) {
        $this->addSql("INSERT INTO TVM_MODULO (MODU_ID, MODU_DESCRIPCION, MODU_URL, MODU_ICONCARACTER, MODU_ORDEN)
            VALUES ('$id', '$desc', '$url', '$icono', $orden)");
    }

    // 6. Qué ve y qué puede hacer cada acceso en cada módulo
    foreach ([
        // Director
        ['COO', 'PERFIL', '4'],   ['COO', 'SOLICITANTES', '4'], ['COO', 'CONSULTAS', '7'],
        ['COO', 'ENTREVISTAS', '15'], ['COO', 'CASOS', '15'],   ['COO', 'AUDIENCIAS', '7'],
        ['COO', 'PERSONAL', '7'], ['COO', 'ESTADISTICAS', '4'],
        // Asesor (profesor)
        ['ASE', 'PERFIL', '4'],   ['ASE', 'ENTREVISTAS', '6'],  ['ASE', 'CASOS', '6'],
        ['ASE', 'AUDIENCIAS', '7'],
        // Estudiante
        ['PRA', 'PERFIL', '4'],   ['PRA', 'CONSULTAS', '15'],   ['PRA', 'ENTREVISTAS', '15'],
        ['PRA', 'CASOS', '15'],   ['PRA', 'AUDIENCIAS', '15'],
        // Secretaria
        ['SEC', 'PERFIL', '4'],   ['SEC', 'SOLICITANTES', '4'], ['SEC', 'CASOS', '4'],
        // Administrativo
        ['ADM', 'PERFIL', '4'],   ['ADM', 'ESTADISTICAS', '4'], ['ADM', 'ESTUDIANTES', '4'],
        ['ADM', 'PROFESORES', '4'],
            ] as [$acce, $modu, $perm]) {
            $this->addSql("INSERT INTO ACCESO_MODULO (ACCE_ID, MODU_ID, PERM_ID) VALUES ('$acce', '$modu', '$perm')");
        }
    }

    public function down(Schema $schema): void
    {
        $this->throwIrreversibleMigrationException('Esta migración reemplaza los datos de menús y permisos.');
    }
}
