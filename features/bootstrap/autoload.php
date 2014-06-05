<?php
require_once __DIR__ . '/../../vendor/autoload.php';

var_dump("In behat bootstrap");

$envVars = array(
    'MYSQL_USER',
    'MYSQL_PASSWORD',
    'MYSQL_DBNAME',
    'MYSQL_HOST',
);

foreach ($envVars as $key) {
    var_dump("checking: " . $key);
    var_dump(getenv($key));
    $behatEnvVar = 'BEHAT_' . $key;
    var_dump("behat equiv: " . $behatEnvVar);
    var_dump(getenv($behatEnvVar));
    if (getenv($behatEnvVar)) {
        var_dump('putting into env');
        putenv($key . '=' . getenv($behatEnvVar));
    }
    var_dump('new value: ' . getenv($key));
}
