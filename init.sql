CREATE DATABASE IF NOT exists api_db;
USE api_db;

CREATE TABLE personas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL,
    apellido VARCHAR(50) NOT NULL,
    tipo_documento VARCHAR(20) NOT NULL,
    numero_documento VARCHAR(20) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);