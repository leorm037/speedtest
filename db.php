<?php

$host = "127.0.0.1";
$db   = "speedtest";
$user = "speedtest";
$pass = "speedtest";

$dsn = "mysql:host=$host;dbname=$db";

$options = [\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION];

try{
        $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e){
        echo $e->getMessage() . "\n";
        echo $e->getCode() . "\n";
}
