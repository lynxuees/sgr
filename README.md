# Sistema de Gestión de Residuos (SGR)

Este proyecto es un **Sistema de Gestión de Residuos (SGR)** desarrollado en **Laravel 11** con **MySQL 8.0**, diseñado para gestionar usuarios, residuos y recolecciones.

---

## **Requisitos Previos**

Se requiere tener instalado:

- **PHP 8.2**
- **Composer**
- **MySQL 8.0**
- **Git**
- **Apache 2.4 con PHP-FPM**
- **Ubuntu 22.04 LTS**
- **Node.js & npm** (para construir assets con Vite y TailwindCSS)
- **Docker & Docker Compose** (si se usa Laravel Sail para el entorno de desarrollo)

---

## **Instalación y Configuración Local**

### **1. Clonar el repositorio**
```
git clone https://github.com/lynxuees/sgr.git
cd sgr
```

### **2. Instalación con Laravel Sail (opcional, recomendado para desarrollo en contenedores)**
Si se utiliza **Laravel Sail**, el entorno puede configurarse fácilmente con Docker.

#### **2.1. Configurar Laravel Sail**
Copiar el archivo de entorno y ajustar la configuración.
```
cp .env.example .env
```

Para ejecutar el entorno con Sail, configurar las siguientes variables en el archivo `.env`:
```
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=sgr
DB_USERNAME=sail
DB_PASSWORD=password
```

#### **2.2. Levantar el entorno con Docker Compose**
```
./vendor/bin/sail up -d
```

Si no se tiene Sail instalado, ejecutarlo con:
```
composer require laravel/sail --dev
php artisan sail:install
```

Después de la instalación, levantar los contenedores con:
```
./vendor/bin/sail up -d
```

---

### **3. Instalación manual (sin Docker)**
Si no se usa Sail, instalar dependencias manualmente:
```
composer install
npm install
```

### **4. Generar la clave de la aplicación**
```
php artisan key:generate
```

### **5. Ejecutar migraciones y seeders**
```
php artisan migrate --seed
```

### **6. Construir assets con Vite**
```
npm run build
```

### **7. Servir la aplicación**
Si se usa Sail:
```
./vendor/bin/sail artisan serve
```
Si se ejecuta manualmente:
```
php artisan serve
```
La aplicación estará disponible en `http://127.0.0.1:8000`

---

## **Despliegue en Producción**

### **1. Configurar el servidor**
Para mantener el sistema actualizado, ejecutar el siguiente comando para actualizar los paquetes del servidor:
```
sudo apt update && sudo apt upgrade -y
```

Instalar las dependencias necesarias:
```
sudo apt install -y php8.2 php8.2-cli php8.2-mysql php8.2-fpm php8.2-curl php8.2-xml php8.2-mbstring unzip git curl mysql-client nodejs npm
```

### **2. Configurar Apache y PHP-FPM**
Habilitar los módulos necesarios:
```
sudo a2enmod rewrite proxy_fcgi setenvif
sudo a2enconf php8.2-fpm
sudo systemctl restart apache2
```

### **3. Clonar el repositorio en el servidor**
```
cd /var/www/
sudo git clone https://github.com/lynxuees/sgr.git
cd sgr
```

### **4. Configurar permisos y propietario**
```
sudo chown -R www-data:www-data /var/www/sgr
sudo chmod -R 775 /var/www/sgr/storage /var/www/sgr/bootstrap/cache
```

### **5. Configurar variables de entorno para producción**
```
cp .env.example .env
nano .env
```
Para producción, es necesario configurar las siguientes variables:
```
APP_ENV=production
DB_CONNECTION=mysql
DB_HOST=<PROD_DB_HOST>
DB_PORT=3306
DB_DATABASE=<PROD_DB_NAME>
DB_USERNAME=<PROD_DB_USER>
DB_PASSWORD=<PROD_DB_PASSWORD>
```
⚠ **Nota:** No utilizar las credenciales de desarrollo en producción para garantizar la seguridad del sistema.

### **6. Instalar dependencias y configurar la aplicación**
```
composer install --no-dev --optimize-autoloader
npm install
npm run build
php artisan key:generate
php artisan migrate --seed
```

### **7. Configurar Apache Virtual Host**
Para configurar Apache, crear un archivo de configuración con el siguiente contenido:
```
sudo nano /etc/apache2/sites-available/sgr.conf
```

Añadir la configuración:
```
<VirtualHost *:80>
    ServerName <DOMINIO_O_IP>
    DocumentRoot /var/www/sgr/public

    <Directory /var/www/sgr/public>
        AllowOverride All
        Require all granted
    </Directory>

    ErrorLog ${APACHE_LOG_DIR}/sgr_error.log
    CustomLog ${APACHE_LOG_DIR}/sgr_access.log combined
</VirtualHost>
```

Para habilitar el sitio y reiniciar Apache, ejecutar los siguientes comandos:
```
sudo a2ensite sgr.conf
sudo systemctl restart apache2
```

---

## **Mantenimiento y Logs**
### **Limpiar caché de Laravel**
```
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

### **Ver logs de Laravel**
```
tail -f storage/logs/laravel.log
```

### **Actualizar dependencias en producción**
```
git pull origin main
composer install --no-dev --optimize-autoloader
npm install
npm run build
php artisan migrate --force
```

---

## **Acceso y Usuarios**
### **Usuarios Iniciales (Seeder)**
- **Admin:** admin@sgr.test / contraseña: `password`
- **Usuario estándar:** user@sgr.test / contraseña: `password`

---
