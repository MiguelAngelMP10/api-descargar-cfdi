# api-descargar-cfdi


## Tabla de contenido

- [Intalación y configuración en local](docs/installation_steps.md)
- [Comandos artisan para crear usuario y generar Bearer token](docs/create_user_and_add_token.md)

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

Usa [`laravel/sail`](https://laravel.com/docs/10.x/sail) si estás familiarizado.

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
