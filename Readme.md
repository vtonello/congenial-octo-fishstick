
# Introducción
El objetivo del desafío es desarrollar una versión funcional que corra.
Realizar una API preparada para recibir requests vía POST y GET.
El POST debe estar preparado para recibir un JSON en el que se mande un nombre, un apellido, un ID de tipo de documento y uno número de documento por separado y debe responder en consecuencia teniendo en cuenta las prácticas REST.
Los datos recibidos deben guardarse en una base de datos relacional.
El GET debe retornar todos los pares NOMBRE / APELLIDO con su correspondiente tipo y número de documento en un JSON. Esta API, debe tener un parámetro opcional que permita el ordenamiento por cualquiera de los datos.

# Componentes

- api.php: Este es el script principal que maneja las solicitudes HTTP y coordina las operaciones de la API.
- database.php: Contiene la clase Database para manejar las operaciones de la base de datos.
- handlers.php: Contiene las funciones para manejar las solicitudes POST y GET.
- cargar_datos.sh: Carga de datos en la base de datos mediante llamadas a la api. (Pruebas)

# Inserción de datos

```
curl -X POST -H "Content-Type: application/json" -d '{"nombre":"Juan","apellido":"Pérez","tipo_documento":"DNI","numero_documento":"12345678"}' http://localhost:9080/api.php
```
# Obtener datos

```
curl http://localhost:9080/api.php
```

# Acceder con un parámetro de ordenamiento
```
curl http://localhost:9080/api.php/nombre
```