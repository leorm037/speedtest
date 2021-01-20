<?php

$server = $_SERVER["SERVER_ADDR"];
$remote = $_SERVER["REMOTE_ADDR"];

$ip_diff = array_diff(explode('.',$server),explode('.',$remote));


if ($ip_diff[3] == 2) {
	$exec = shell_exec(__DIR__ . '/speedtest-meter.sh');

	echo "true";
} else {
	echo "false";
}
