# api-descargar-cfdi




[Documentación completa](http://gentle-anchorage-55410.herokuapp.com/docs/)




* Ejemplos de uso con UI con  inertiajs en desarrollo


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
<!-- 
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
-->
## Contribuciones

Estamos abiertos a contribuciones de código, documentación, entorno de desarrollo, reporte de problemas,
discusión de nuevas ideas, etc. Lee nuestra [guía de contribución](CONTRIBUTING.md).

## Copyright and License

The `MiguelAngelMP10/api-descargar-cfdi` proyect is copyright © [Miguel Angel Muñoz Pozos](a)
and licensed for use under the MIT License (MIT). Please see [LICENSE](https://github.com/MiguelAngelMP10/api-descargar-cfdi/blob/main/LICENSE) for more information.
