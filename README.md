# Sistema de Gestión de Residuos (SGR)

Este proyecto es un **Sistema de Gestión de Residuos (SGR)** desarrollado en **Laravel 11** con **MySQL 8.0**, diseñado para gestionar usuarios, residuos, recolecciones y reportes.

---

## **Requisitos Previos**

Antes de comenzar, asegúrate de tener instalado:

- **PHP 8.2**
- **Composer**
- **MySQL 8.0**
- **Git**
- **Apache 2.4 con PHP-FPM**
- **Ubuntu 22.04 LTS**

---

## **Instalación y Configuración Local**

### **1. Clonar el repositorio**
```bash
git clone https://github.com/lynxuees/sgr.git
cd sgr
```

### **2. Instalar dependencias**
```bash
composer install
```

### **3. Configurar variables de entorno**
Copia el archivo de entorno y ajusta la configuración según tu entorno local:
```bash
cp .env.example .env
```

Configura la conexión a la base de datos en `.env`:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=sgr
DB_USERNAME=db_user
DB_PASSWORD=db_password
```

### **4. Generar la clave de la aplicación**
```bash
php artisan key:generate
```

### **5. Ejecutar migraciones y seeders**
```bash
php artisan migrate --seed
```

### **6. Servir la aplicación**
```bash
php artisan serve
```
La aplicación estará disponible en `http://127.0.0.1:8000`

---

## **Despliegue en Servidor**

### **1. Configurar el servidor**
Actualizar los paquetes del server:
```bash
sudo apt update && sudo apt upgrade -y
```

Instalar las dependencias necesarias:
```bash
sudo apt install -y php8.2 php8.2-cli php8.2-mysql php8.2-fpm php8.2-curl php8.2-xml php8.2-mbstring unzip git curl mysql-client
```

### **2. Configurar Apache y PHP-FPM**
Habilitar los módulos necesarios:
```bash
sudo a2enmod rewrite proxy_fcgi setenvif
sudo a2enconf php8.2-fpm
sudo systemctl restart apache2
```

### **3. Clonar el repositorio en el servidor**
```bash
cd /var/www/
sudo git clone https://github.com/tu-usuario/sgr.git
cd sgr
```

### **4. Configurar permisos y propietario**
```bash
sudo chown -R www-data:www-data /var/www/sgr
sudo chmod -R 775 /var/www/sgr/storage /var/www/sgr/bootstrap/cache
```

### **5. Configurar variables de entorno en producción**
```bash
cp .env.example .env
nano .env
```
Modificar las variables de producción, como `APP_ENV=production`, `DB_HOST`, `DB_DATABASE`, `DB_USERNAME` y `DB_PASSWORD`.

### **6. Instalar dependencias y configurar la aplicación**
```bash
composer install --no-dev --optimize-autoloader
php artisan key:generate
php artisan config:cache
php artisan route:cache
php artisan migrate --seed
```

### **7. Configurar Apache Virtual Host**
Crear un archivo de configuración para Apache:
```bash
sudo nano /etc/apache2/sites-available/sgr.conf
```

Añadir la configuración:
```
<VirtualHost *:80>
    ServerName 172.171.226.14
    DocumentRoot /var/www/sgr/public

    <Directory /var/www/sgr/public>
        AllowOverride All
        Require all granted
    </Directory>

    ErrorLog ${APACHE_LOG_DIR}/sgr_error.log
    CustomLog ${APACHE_LOG_DIR}/sgr_access.log combined
</VirtualHost>
```

Habilitar el sitio y reinicia Apache:
```bash
sudo a2ensite sgr.conf
sudo systemctl restart apache2
```

---

## **Mantenimiento y Logs**
### **Limpiar caché de Laravel**
```bash
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

### **Ver logs de Laravel**
```bash
tail -f storage/logs/laravel.log
```

### **Actualizar dependencias en producción**
```bash
git pull origin main
composer install --no-dev --optimize-autoloader
php artisan migrate --force
```

---

## **Acceso y Usuarios**
### **Usuarios Iniciales (Seeder)**
- **Admin:** admin@example.com / contraseña: `password`
- **Usuario estándar:** user@example.com / contraseña: `password`

---
