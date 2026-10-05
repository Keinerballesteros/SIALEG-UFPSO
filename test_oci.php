<?php
require __DIR__ . '/vendor/autoload.php';

use Symfony\Component\Dotenv\Dotenv;

// Carga .env, .env.local, .env.dev y .env.dev.local, igual que Symfony
(new Dotenv())->bootEnv(__DIR__ . '/.env');

// Las variables reales del sistema (como DB_HOST en Docker) tienen prioridad
function envv(string $key, ?string $default = null): ?string
{
    $v = $_ENV[$key] ?? $_SERVER[$key] ?? getenv($key);
    return ($v === false || $v === null || $v === '') ? $default : $v;
}

$user    = envv('DB_USER', 'sialeg');
$pass    = envv('DB_PASSWORD');
$host    = envv('DB_HOST', 'localhost');
$service = envv('DB_SERVICE', 'XEPDB1');

if ($pass === null) {
    die("Falta DB_PASSWORD en tus archivos .env" . PHP_EOL);
}

$c = oci_connect($user, $pass, "//{$host}:1521/{$service}", 'AL32UTF8');
if (!$c) {
    $e = oci_error();
    die($e['message'] . PHP_EOL);
}

$s = oci_parse($c, "SELECT 'Conectado a Oracle' AS msg FROM dual");
oci_execute($s);
$r = oci_fetch_assoc($s);
echo $r['MSG'] . PHP_EOL;
