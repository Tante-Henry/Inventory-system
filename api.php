<?php
require_once __DIR__ . '/app/Product.php';
require_once __DIR__ . '/app/Pos.php';
require_once __DIR__ . '/app/GRN.php';
require_once __DIR__ . '/app/Auth.php';
require_once __DIR__ . '/app/Lang.php';

header('Content-Type: application/json');
$method = $_SERVER['REQUEST_METHOD'];
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
Lang::setLocale($_GET['lang'] ?? 'en');

function authUser() {
    $headers = getallheaders();
    if (!isset($headers['Authorization'])) return null;
    $token = trim(str_replace('Bearer', '', $headers['Authorization']));
    return Auth::jwtDecode($token);
}

switch (true) {
    case $path === '/api/login' && $method === 'POST':
        $data = json_decode(file_get_contents('php://input'), true);
        $token = Auth::login($data['name'], $data['password']);
        if (!$token) {http_response_code(401); echo json_encode(['error'=>Lang::get('login_failed')]); break;}
        echo json_encode(['token'=>$token]);
        break;
    case $path === '/api/products' && $method === 'GET':
        echo json_encode(Product::all());
        break;
    case $path === '/api/products' && $method === 'POST':
        $user = authUser();
        if (!$user || $user['role'] !== 'admin') {http_response_code(403); echo json_encode(['error'=>Lang::get('unauthorized')]); break;}
        $data = json_decode(file_get_contents('php://input'), true);
        $product = Product::create($data['name'], $data['price'], $data['stock']);
        echo json_encode($product);
        break;
    default:
        http_response_code(404);
        echo json_encode(['error'=>Lang::get('not_found')]);
}
