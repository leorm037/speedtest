<?php

namespace PaginaEmConstrucao\Core;

class Connection
{
    /** @const array */
    private const OPTIONS = [
        \PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
        \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
        \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_OBJ,
        \PDO::ATTR_CASE => \PDO::CASE_NATURAL
    ];
    
    /** @var \PDO */
    private static $instance;
    
    public static function getInstance(): ?\PDO {
        if (empty(self::$instance)) {
            try {
                self::$instance = new \PDO(
                        "mysql:host=" . CONF_DB_HOST . ":" . CONF_DB_PORT . ";dbname=" . CONF_DB_NAME,
                        CONF_DB_USER,
                        CONF_DB_PASS,
                        self::OPTIONS
                );
            } catch (Exception $exception) {
                redirect("error/404");
            }
        }
        return self::$instance;
    }
}
