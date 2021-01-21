<?php

/*
 * #######################
 * ###   PROJECT URL   ###
 * #######################
 */

define("CONF_URL_BASE_DEV", "http://localhost/speedtest");
define("CONF_URL_BASE", "http://" . $_SERVER['HTTP_HOST'] . "/speedtest");


/*
 * #####################
 * ###    DATABASE   ###
 * #####################
 */

define("CONF_DB_HOST", "localhost");
define("CONF_DB_PORT", "3306");
define("CONF_DB_NAME", "speedtest");
define("CONF_DB_USER", "speedtest");
define("CONF_DB_PASS", "");

/*
 * ################
 * ###   VIEW   ###
 * ################
 */

define("CONF_VIEW_PATH", __DIR__ . "/../../themes");
define("CONF_VIEW_EXT", "php");
define("CONF_VIEW_THEME", "speedtest");

