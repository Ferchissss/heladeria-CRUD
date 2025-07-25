# 🍦 Heladería Web - Sistema de Pedidos Personalizados

## 📝 Descripción del Proyecto

Este proyecto consiste en una *aplicación web para una heladería*, diseñada para brindar una experiencia personalizada a los clientes. A través de esta plataforma, los usuarios pueden:

- Explorar el menú de helados por categorías.
- Realizar pedidos en línea desde la comodidad de su hogar.
- Personalizar sus productos eligiendo o quitando ingredientes.
- Aplicar promociones activas al momento de la compra.
- Acumular puntos mediante un sistema de fidelización.
- Recibir notificaciones sobre nuevos sabores, descuentos y ofertas especiales.

El sistema está desarrollado en Laravel 11 y usa MySQL como base de datos relacional, manteniendo una arquitectura clara y escalable para facilitar el proyecto.

---
🛠 Requisitos Técnicos
PHP 8.2+

Composer 2.5+

MySQL 8.0+

Laravel 10+

## ⚙️ Cómo ejecutar el proyecto

Sigue estos pasos para ejecutar el proyecto en tu entorno local:

### 1. Clonar el repositorio

git clone https://github.com/tuusuario/sistema-academico.git

cd heladeria

### 2. Instalar dependencias
composer install

### 3. Configurar entorno
cp .env.example .env

php artisan key:generate

Editar .env con tus credenciales:

env

DB_DATABASE=heladeria

DB_USERNAME=root

DB_PASSWORD=

### 4. Ejecutar migraciones y seeders
php artisan migrate --seed

### 5. Iniciar servidor
php artisan serve

Abrir en navegador: http://localhost:8000

### Evidencias de la Tarea
Migraciones y seeders ejecutadas correctamente

Base de datos generada con datos random 

Interfaz gráfica funcional y navegable

Formularios con validaciones y mensajes de error

Operaciones CRUD completas sobre entidades clave: productos, pedidos, clientes, ingredientes

![1](img/1.png)  
![2](img/2.png)  
![3](img/3.png)  
![4](img/4.png)  
![5](img/5.png)  
![6](img/6.png)  
![7](img/7.png)  
![8](img/8.png)  
![9](img/9.png)  

### 💡 Funcionalidades CRUD Completadas

Entidad	Crear	Leer	Actualizar	Eliminar

Clientes	✅	✅	✅	✅

Productos	✅	✅	✅	✅

Ingredientes	✅	✅	✅	✅

Pedidos	✅	✅	✅	✅

Categorías	✅	✅	✅	✅



📜 Licencia  
MIT License - Copyright (c) 2025 Fernanda Estrada - Celeste Ortiz

