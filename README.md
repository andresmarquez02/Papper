
# Papper

Esta es es una aplicacion al estilo de yahoo, sew trata de realizar preguntas que otros usuarios respondan 

Papper es una practica que realice hace muchos dias cuando estaba iniciando mi trabajo, esta se realizo 
en la version de 5.4 de laravel.

Tecnologias que use: Laravel 5.4, Bootstrap 4 y Vue 2


## Instalacion

Para poder usar esta app o realizarle cambios primero debes seguir estos pasos.

Paso 1: Clona el proyecto

```bash
    git clone https://github.com/andresmarquez02/Papper.git
    cd Papper
```

Paso 2: Instala composer

```bash
    composer install
```

Paso 3: cambia el nombre del archivo .env.example a .env

Paso 4: Ejecuta en la terminal

```bash
    php artisan key:generate --show
```
Copia esta llave de encriptacion y pegala en las variables de entorno

`APP_KEY`

Paso 5: Crea una base de datos, copia el nombre y pegala en las variables de entorno

`DB_DATABASE`

Paso 6: Ejecuta en la terminal este comando

```bash
    php artisan migrate:fresh --seed
```

Si quieres cambiar algo en el sistema en referencias en javascript puedes instalar los paquetes de node

```bash
    npm install
```
## Ejecucion del Sistema

Para que el sistema funcione correctamente debes escribir este comando

```bash
    php artisan serve
```
## Usuarios con los que te puedes loguear en Papper

| Correo    | Contraseña     | Rol                |
| :-------- | :------- | :------------------------- |
| `admin@papper.com` | `123123` | Admin |
| `andres03marquez@gmail.com` | `123123` | Natural |

## Autor

- [@andresmarquez](https://www.github.com/andresmarquez02)

## 🔗 Links
[![portafolio](https://img.shields.io/badge/my_portfolio-000?style=for-the-badge&logo=ko-fi&logoColor=white)](https://andresmarquez02.github.io/)
[![linkedin](https://img.shields.io/badge/linkedin-0A66C2?style=for-the-badge&logo=linkedin&logoColor=white)](https://www.linkedin.com/in/andres-marquez-02/)
