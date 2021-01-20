<?php

/*
 * #################
 * ###   ERROR   ###
 * #################
 */

/** @return void */
function error(): void
{
    if (strpos(filter_input(INPUT_SERVER, "HTTP_HOST"), 'localhost') !== false) {
        ini_set("display_errors", 1);
        ini_set("error_reporting", E_ALL);
        ini_set('xdebug.overload_var_dump', 1);
    } else {
        ini_set("display_errors", 0);
        ini_set("error_reporting", E_ERROR);
        ini_set('xdebug.overload_var_dump', 0);
    }
}

/* ###############
 * ###   URL   ###
 * ###############
 */

function url(string $path = null): string
{
    if (strpos(filter_input(INPUT_SERVER, "HTTP_HOST"), 'localhost') !== false) {
        if ($path) {
            return CONF_URL_BASE_DEV . "/" . ($path[0] == "/" ? mb_substr($path, 1) : $path);
        }
        return CONF_URL_BASE_DEV;
    }

    if ($path) {
        return CONF_URL_BASE . "/" . ($path[0] == "/" ? mb_substr($path, 1) : $path);
    }

    return CONF_URL_BASE;
}

function redirect(string $url): void
{
    header("HTTP/1.1 302 Redirect");
    if (filter_var($url, FILTER_VALIDATE_URL)) {
        header("Location: {$url}");
        exit;
    }

    if (filter_input(INPUT_GET, "route", FILTER_DEFAULT) != $url) {
        $location = url($url);
        header("Location: {$location}");
        exit;
    }
}

function theme(string $path = null): string
{
    if (strpos(filter_input(INPUT_SERVER, "HTTP_HOST"), 'locahost') !== false) {
        if ($path) {
            return CONF_URL_BASE_DEV . "/themes/" . CONF_VIEW_THEME . "/" . ($path[0] == "/" ? mb_substr($path, 1) : $path);
        }
        return CONF_URL_BASE_DEV . "/themes/" . CONF_VIEW_THEME;
    }

    if ($path) {
        return CONF_URL_BASE . "/themes/" . CONF_VIEW_THEME . "/" . ($path[0] == "/" ? mb_substr($path, 1) : $path);
    }
    return CONF_URL_BASE . "/themes/" . CONF_VIEW_THEME;
}

function url_back(): string {
    return filter_id(INPUT_SERVER, "HTTP_REFERER") ?? url();
}
