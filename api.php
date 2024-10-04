<?php

define('DB_HOST', getenv('DB_HOST') ?: '127.0.0.1');
define('DB_NAME', getenv('DB_NAME') ?: 'api_db');
define('DB_USER', getenv('DB_USER') ?: 'root');
define('DB_PASS', getenv('DB_PASS') ?: 'qwerty123');

require_once 'database.php';
require_once 'handlers.php';

set_error_handler("errorHandler");
set_exception_handler("exceptionHandler");

$method = $_SERVER['REQUEST_METHOD'];

$path = $_SERVER['PATH_INFO'] ?? $_SERVER['REQUEST_URI'] ?? '';
$path = parse_url($path, PHP_URL_PATH);
$request = explode('/', trim($path, '/'));

try {

    $db = new Database(DB_HOST, DB_NAME, DB_USER, DB_PASS);

    switch ($method) {
        case 'POST':
            handlePost($db);
            break;
        case 'GET':
            handleGet($db, $request);
            break;
        default:
            throw new Exception('Método no permitido', 405);
    }

    $db->close();
} catch (Exception $e) {
    sendErrorResponse($e->getCode() ?: 500, $e->getMessage());
}