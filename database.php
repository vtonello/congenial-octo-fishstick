<?php

class Database
{
    private $conn;

    public function __construct($host, $dbname, $user, $pass)
    {
        try {
            $this->conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $user, $pass);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        } catch (PDOException $e) {
            throw new Exception("Error de conexión a la base de datos: " . $e->getMessage(), 500);
        }
    }

    public function insert($nombre, $apellido, $tipo_documento, $numero_documento)
    {
        try {
            // Validación adicional de datos
            $nombre = $this->sanitizeInput($nombre);
            $apellido = $this->sanitizeInput($apellido);
            $tipo_documento = $this->sanitizeInput($tipo_documento);
            $numero_documento = $this->sanitizeInput($numero_documento);

            // Verificar longitud máxima
            if (strlen($nombre) > 50 || strlen($apellido) > 50 ||
                strlen($tipo_documento) > 20 || strlen($numero_documento) > 20) {
                throw new Exception("Uno o más campos exceden la longitud máxima permitida.", 400);
            }

            $sql = "INSERT INTO personas (nombre, apellido, tipo_documento, numero_documento) VALUES (?, ?, ?, ?)";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$nombre, $apellido, $tipo_documento, $numero_documento]);
            return $this->conn->lastInsertId();
        } catch (PDOException $e) {
            // Log del error real para debugging (no mostrar al usuario)
            error_log("Error de base de datos: " . $e->getMessage());
            throw new Exception("Error al insertar datos. Por favor, inténtelo de nuevo.", 500);
        }
    }

    private function sanitizeInput($input)
    {
        $input = trim($input);
        $input = stripslashes($input);
        return htmlspecialchars($input, ENT_QUOTES, 'UTF-8');
    }

    public function getAll($orderBy = 'id')
    {
        try {
            $allowedColumns = ['id', 'nombre', 'apellido', 'tipo_documento', 'numero_documento'];
            $orderBy = in_array($orderBy, $allowedColumns) ? $orderBy : 'id';
            $sql = "SELECT nombre, apellido, tipo_documento, numero_documento FROM personas ORDER BY $orderBy";
            $stmt = $this->conn->query($sql);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Error al obtener datos: " . $e->getMessage(), 500);
        }
    }

    public function close()
    {
        $this->conn = null;
    }
}