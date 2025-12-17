📌 API – Gestor de Proyectos y Tareas (projecTask)

Esta es la API REST desarrollada en Laravel para la gestión de proyectos y tareas.
Se encarga de exponer los endpoints necesarios para que una aplicación cliente (por ejemplo, una página web o una app móvil) pueda:

🔹 Registrar e iniciar sesión en usuarios
🔹 Crear, ver, actualizar y eliminar proyectos
🔹 Crear tareas dentro de proyectos
🔹 Marcar tareas como completadas o pendientes

🚀 Tecnologías

Laravel 10

PHP 8.2

MySQL (o cualquier base de datos soportada)

Laravel Sanctum para autenticación de API

🚧 Requisitos Previos

Antes de usar la API debes tener:

✔ PHP 8+
✔ Composer
✔ Base de datos (MySQL)
✔ Laravel instalado

📦 Instalación

Clona el repositorio:

git clone https://github.com/Feliandres41/projecTask.git


Entra al proyecto:

cd projecTask


Instala dependencias:

composer install


Crea el archivo de entorno y la clave de la app:

cp .env.example .env
php artisan key:generate


Configura tu base de datos en .env, por ejemplo:

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=projectsTask
DB_USERNAME=root
DB_PASSWORD=


Luego ejecuta migraciones:

php artisan migrate


Finalmente levanta el servidor:

php artisan serve


Por defecto correrá en:

http://127.0.0.1:8000

📡 Endpoints de la API

✔ Autenticación

Método	Endpoint	Acción
POST	/api/register	Registrar usuario
POST	/api/login	Iniciar sesión

✔ Proyectos

Método	Endpoint	Acción
GET	/api/projects	Listar proyectos del usuario
POST	/api/projects	Crear proyecto
GET	/api/projects/{id}	Ver un proyecto
PUT	/api/projects/{id}	Actualizar un proyecto
DELETE	/api/projects/{id}	Eliminar un proyecto

✔ Tareas

Método	Endpoint	Acción
POST	/api/tasks	Crear una tarea
PUT	/api/tasks/{id}/complete	Marcar completa una tarea
🧠 ¿Cómo funciona?

La API utiliza Tokens de acceso con Laravel Sanctum, por lo que cada petición protegida debe incluir:

Authorization: Bearer {token}


Ese token lo obtienes cuando haces login:

POST /api/login
{
  "email": "usuario@mail.com",
  "password": "password"
}


Respuesta:

{
  "token": "eyJ0eXAiOiJKV1QiLCJh..."
}


Ese token lo usas luego para consumir cualquier endpoint protegido.
