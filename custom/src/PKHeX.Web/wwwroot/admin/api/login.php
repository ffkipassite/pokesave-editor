<?php
session_start();
header('Content-Type: application/json; charset=utf-8');
$data = json_decode(file_get_contents(dirname(__DIR__) . '/data/admin.json'), true);
$input = json_decode(file_get_contents('php://input'), true);
if (is_array($data) && is_array($input) && isset($input['password']) && password_verify($input['password'], $data['passwordHash'])) {
  session_regenerate_id(true); $_SESSION['admin_ok'] = true; echo json_encode(['ok'=>true]); exit;
}
http_response_code(401); echo json_encode(['error'=>'Invalid password']);
