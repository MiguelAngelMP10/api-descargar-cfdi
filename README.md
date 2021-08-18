# api-descargar-cfdi


pasos para iniciar el proyecto en local

* Clonar el repositorio siempre y cuando seas colaborador
 ```bash
git clone https://github.com/MiguelAngelMP10/api-descargar-cfdi.git
```
* moverse a la carpeta del proyecto 
 ```bash
    cd api-descargar-cfdi
```

## instalación de dependecias 
```bash
composer install
```
## configuaciones
* Realizar copia del archivo .env.example
    ```
       cp .env.example .env
    ```

* Generar key de aplicación
    ```bash
    php artisan key:generate
    ```
 * Arrancamos el proyecto con 
    ```bash
       php artisan serve
    ```

* Lista de endPoints
   ```
    - /api/v1/send-cer-key
    - /api/v1/make-query
    - /api/v1/verify-query
    - /api/v1/download-packages
    ```

link de documentación en **postman** 

https://documenter.getpostman.com/view/6966544/TzXwEyTD

## Ejecución con *Docker*

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

## Copyright and License

The `MiguelAngelMP10/api-descargar-cfdi` proyect is copyright © [Miguel Angel Muñoz Pozos](a)
and licensed for use under the MIT License (MIT). Please see [LICENSE](https://github.com/MiguelAngelMP10/api-descargar-cfdi/blob/main/LICENSE) for more information.
