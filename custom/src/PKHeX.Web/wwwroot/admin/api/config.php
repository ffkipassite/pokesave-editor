<?php
header('Content-Type: application/json; charset=utf-8');
header('Cache-Control: no-store, no-cache, must-revalidate');
$configFile = dirname(__DIR__) . '/data/config.json';
if (!is_file($configFile)) { http_response_code(500); echo json_encode(['error'=>'Configuration unavailable']); exit; }
$data = json_decode(file_get_contents($configFile), true);
if (!is_array($data)) { http_response_code(500); echo json_encode(['error'=>'Invalid configuration']); exit; }
echo json_encode($data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
