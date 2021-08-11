# Uso de docker

Estas son algunas ideas para crear una imagen de docker de este proyecto.

## Estrategia de uso creando la imagen en forma local

1. Construir la imagen

## Estrategia de uso publicando la imagen en dockerhub

docker run -p 80:8081 -v $HOME/descarga-data:/var/www/storage/data api-descargar-cfdi:latest

1. Construir la imagen
2. Publicar la imagen en dockerhub
3. Automatizar el proceso de creación de imágenes
4. Incluir un proceso automático de actualización de dependencias (dependabot)

## Construcción de la imagen

Crear un Dockerfile basado en ubuntu o debian con la instalación de dependencias

Crear la documentación para construir la imagen y ejecutar un contenedor con la imagen

Seguridad de la aplicación: ejecución como root/usuario y montaje de archivos.

## Laravel-way

Las aplicaciones de Laravel acostumbran utilizar laravel/sail como virtualización del entorno de desarrollo y ejecución.
Vea la documentación de [laravel/sail](https://laravel.com/docs/8.x/sail) para usar este proyecto de esta forma.
