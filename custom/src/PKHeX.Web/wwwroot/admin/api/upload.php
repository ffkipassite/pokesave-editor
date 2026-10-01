<?php
session_start();
header('Content-Type: application/json; charset=utf-8');
if (empty($_SESSION['admin_ok'])) { http_response_code(401); echo json_encode(['error'=>'Unauthorized']); exit; }
if (empty($_FILES['logo']) || $_FILES['logo']['error'] !== UPLOAD_ERR_OK) { http_response_code(400); echo json_encode(['error'=>'No logo uploaded']); exit; }
$f = $_FILES['logo'];
if ($f['size'] > 2 * 1024 * 1024) { http_response_code(400); echo json_encode(['error'=>'Logo must be 2 MB or smaller']); exit; }
$info = @getimagesize($f['tmp_name']);
$allowed = [IMAGETYPE_PNG=>'png', IMAGETYPE_JPEG=>'jpg', IMAGETYPE_WEBP=>'webp', IMAGETYPE_GIF=>'gif'];
if (!$info || !isset($allowed[$info[2]])) { http_response_code(400); echo json_encode(['error'=>'Use PNG, JPG, WEBP or GIF']); exit; }
$name = 'logo-' . time() . '.' . $allowed[$info[2]];
$dir = dirname(__DIR__) . '/uploads';
if (!is_dir($dir)) mkdir($dir, 0755, true);
if (!move_uploaded_file($f['tmp_name'], $dir . '/' . $name)) { http_response_code(500); echo json_encode(['error'=>'Could not save logo']); exit; }
$configFile = dirname(__DIR__) . '/data/config.json';
$config = json_decode(file_get_contents($configFile), true); if (!is_array($config)) $config=[];
$config['logoUrl'] = 'admin/uploads/' . $name;
file_put_contents($configFile, json_encode($config, JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE), LOCK_EX);
echo json_encode(['ok'=>true,'logoUrl'=>$config['logoUrl']]);
