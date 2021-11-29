# api-descargar-cfdi

pasos para iniciar el proyecto de forma local

-   Clonar el repositorio

```bash
    git clone https://github.com/MiguelAngelMP10/api-descargar-cfdi.git
```

-   Moverse a la carpeta del proyecto

```bash
   cd api-descargar-cfdi
```

## Instalación de dependecias

```bash
composer install
```

## Configuraciones

-   Realizar copia del archivo .env.example

    ```
       cp .env.example .env
    ```

-   Generar key de aplicación
    ```bash
        php artisan key:generate
    ```
-   Configuración de bases de datos ya sea con _SQLite o MySql_

    -   SQLite

        -   Crear archivo .sqlite

        ```bash
            touch database/database.sqlite
        ```

        -   Configurar en archivo .env los siguientes valores

        ```env
            DB_CONNECTION=sqlite
            DB_DATABASE=/absolute/path/to/database.sqlite
        ```

    -   MySql

        -   Crear base de datos en el motor de bases de datos
        -   Configurar en archivo .env los siguientes valores

        ```env
            DB_CONNECTION=mysql
            DB_HOST=
            DB_PORT=
            DB_DATABASE=
            DB_USERNAME=
            DB_PASSWORD=
        ```

-   Se ejecutan las migraciones para construir las tablas necesarias

    ```bash
       php artisan migrate
    ```

    ```bash
        Migration table created successfully.
        Migrating: 2014_10_12_000000_create_users_table
        Migrated:  2014_10_12_000000_create_users_table (136.28ms)
        Migrating: 2014_10_12_100000_create_password_resets_table
        Migrated:  2014_10_12_100000_create_password_resets_table (74.94ms)
        Migrating: 2019_08_19_000000_create_failed_jobs_table
        Migrated:  2019_08_19_000000_create_failed_jobs_table (110.58ms)
        Migrating: 2019_12_14_000001_create_personal_access_tokens_table
        Migrated:  2019_12_14_000001_create_personal_access_tokens_table (94.67ms)
    ```

## Comandos artisan para crear usuario y generar Bearer token

### Creación de usuario

_El siguiente comando le preguntará los datos del usuario y como resultado obtendrá un mensaje que contiene el `ID` del usuario._

```bash
    php artisan user:create
```

### Creación de tokens

_El siguiente comando registrará un token para el `userId` pasado como argumento y como resultado obtendrá el token._

```bash
    php artisan token:create {userId}
```

## Arrancamos el proyecto con

```bash
    php artisan serve
```

## Validaciones de código

-   larastan:

    ```bash
       ./vendor/bin/phpstan
    ```

-   phpinsights:

    ```bash
      php artisan insights
    ```

-   phpcs:

    ```bash
       ./vendor/bin/phpcs --error-severity=1 --warning-severity=8 --extensions=php
    ```

-   Lista de endPoints
    ```text
     - POST /api/v1/send-cer-key
     - POST /api/v1/make-query
     - POST /api/v1/verify-query
     - POST /api/v1/download-packages
     - GET /api/v1/{rfc}/packages
     - GET /api/v1/{rfc}/packages/{packageId}
     - DELETE /api/v1/{rfc}/packages/{packageId}
    ```

Los endpoints antes mencionados requieren autenticación (bearer token), por lo que en los requests debera agregar un header `Authorization: Bearer {token}`

## Ejemplos

[Ejemplos de end points](docs)

## Ejecución con _Docker_

Usa [`laravel/sail`](https://laravel.com/docs/8.x/sail) si estás familiarizado.

También puedes crear la imagen de docker en tu máquina y levantar un contenedor,
como se muestra en [`docker/Docker.md`](docker/Docker.md).

```shell
git clone https://github.com/MiguelAngelMP10/api-descargar-cfdi.git

cd api-descargar-cfdi

docker build -t api-descargar-cfdi -f docker/Dockerfile .

docker run --name=api-descargar-cfdi --detach=true --publish 8081:80 \
  --volume $HOME/api-descargar-cfdi-data:/opt/api-descargar-cfdi/storage/app/datos/ \
  api-descargar-cfdi

```

## Contribuciones

Estamos abiertos a contribuciones de código, documentación, entorno de desarrollo, reporte de problemas,
discusión de nuevas ideas, etc. Lee nuestra [guía de contribución](CONTRIBUTING.md).

## Copyright and License

The `MiguelAngelMP10/api-descargar-cfdi` proyect is copyright © [Miguel Angel Muñoz Pozos](a)
and licensed for use under the MIT License (MIT). Please see [LICENSE](https://github.com/MiguelAngelMP10/api-descargar-cfdi/blob/main/LICENSE) for more information.
