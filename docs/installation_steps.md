# Intalación y configuración en local

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

