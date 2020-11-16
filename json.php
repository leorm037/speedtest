<?php

require_once('db.php');

header('Content-Type: application/json');

$sql = "SELECT CONVERT_TZ(timestamp,'+00:00','-03:00') as timestamp, download, upload FROM speedtest ORDER BY timestamp DESC LIMIT 40";

$stmt = $pdo->query($sql);

$velocidades = $stmt->fetchAll();

foreach($velocidades as $velocidade){
	$timestamp = $velocidade['timestamp'];
	$download = (float)$velocidade['download'];
	$upload = (float)$velocidade['upload'];

	$data[] = array($timestamp,$download,$upload);
}

echo json_encode(array_reverse($data));

$pdo = null;
