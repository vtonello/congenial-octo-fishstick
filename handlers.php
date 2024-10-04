<?php
/**
 * @param $db
 * @return void
 * @throws Exception
 */
function handlePost($db)
{
    $input = json_decode(file_get_contents('php://input'), true);

    // Validar datos de entrada
    $errors = validateInput($input);
    if (!empty($errors)) {
        throw new Exception(json_encode($errors), 400);
    }

    // Insertar datos en la base de datos
    $id = $db->insert($input['nombre'], $input['apellido'], $input['tipo_documento'], $input['numero_documento']);

    http_response_code(201);
    echo json_encode(['message' => 'Registro creado exitosamente', 'id' => $id]);
}

function validateInput($input)
{
    $errors = [];
    $requiredFields = ['nombre', 'apellido', 'tipo_documento', 'numero_documento'];

    foreach ($requiredFields as $field) {
        if (!isset($input[$field]) || empty(trim($input[$field]))) {
            $errors[$field] = "El campo $field es requerido";
        }
    }

    // Validación adicional
    if (isset($input['nombre'])) {
        if (!preg_match("/^[a-zA-Z ]{1,50}$/", $input['nombre'])) {
            $errors['nombre'] = "El nombre solo debe contener letras y espacios, y no exceder 50 caracteres";
        }
    }

    if (isset($input['apellido'])) {
        if (!preg_match("/^[a-zA-Z ]{1,50}$/", $input['apellido'])) {
            $errors['apellido'] = "El apellido solo debe contener letras y espacios, y no exceder 50 caracteres";
        }
    }

    if (isset($input['tipo_documento'])) {
        if (!preg_match("/^[a-zA-Z0-9]{1,20}$/", $input['tipo_documento'])) {
            $errors['tipo_documento'] = "El tipo de documento solo debe contener letras y números, y no exceder 20 caracteres";
        }
    }

    if (isset($input['numero_documento'])) {
        if (!preg_match("/^[a-zA-Z0-9-]{1,20}$/", $input['numero_documento'])) {
            $errors['numero_documento'] = "El número de documento solo debe contener letras, números y guiones, y no exceder 20 caracteres";
        }
    }

    return $errors;
}

function handleGet($db, $request)
{
    $orderBy = isset($request[0]) ? $request[0] : 'id';
    $data = $db->getAll($orderBy);
    echo json_encode($data);
}

function sendErrorResponse($code, $message)
{
    http_response_code($code);
    echo json_encode(['error' => $message]);
}

function errorHandler($errno, $errstr, $errfile, $errline)
{
    throw new ErrorException($errstr, 0, $errno, $errfile, $errline);
}

function exceptionHandler($exception)
{
    $code = $exception->getCode() ?: 500;
    sendErrorResponse($code, $exception->getMessage());
}
