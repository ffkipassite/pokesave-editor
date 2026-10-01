<?php
session_start();
header('Content-Type: application/json; charset=utf-8');
if (empty($_SESSION['admin_ok'])) { http_response_code(401); echo json_encode(['error'=>'Unauthorized']); exit; }
$configFile = dirname(__DIR__) . '/data/config.json';
$allowed = ['siteName','headerText','footerText','logoUrl','faviconUrl','primaryColor','primaryHoverColor','buttonColor','buttonHoverColor','backgroundColor','surfaceColor','textColor','mutedColor','borderColor','showPlugins','showAnalytics','showSave','showOpen','showSource'];
$input = json_decode(file_get_contents('php://input'), true);
if (!is_array($input)) { http_response_code(400); echo json_encode(['error'=>'Invalid JSON']); exit; }
$current = is_file($configFile) ? json_decode(file_get_contents($configFile), true) : [];
if (!is_array($current)) $current = [];
foreach ($allowed as $key) if (array_key_exists($key, $input)) $current[$key] = $input[$key];
$colors = ['primaryColor','primaryHoverColor','buttonColor','buttonHoverColor','backgroundColor','surfaceColor','textColor','mutedColor','borderColor'];
foreach ($colors as $key) if (isset($current[$key]) && !preg_match('/^#[0-9a-fA-F]{6}$/', $current[$key])) { http_response_code(400); echo json_encode(['error'=>"Invalid color: $key"]); exit; }
file_put_contents($configFile, json_encode($current, JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES), LOCK_EX);
echo json_encode(['ok'=>true]);
