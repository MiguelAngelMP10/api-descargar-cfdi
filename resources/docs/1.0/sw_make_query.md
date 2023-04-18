# sw:make:query

Este comando permite la creación de una consulta ante el servicio web de descarga masiva del sat.

## Mostrar ayuda del comando

```bash
  php artisan sw:make:query -h
 ```

![sw:make:query](/images-docs/sw:make:query.png)

## Ejemplo de uso

```bash
  php artisan sw:make:query tests/_files/fake-fiel/EKU9003173C9.cer tests/_files/fake-fiel/EKU9003173C9.key -p 12345678a -s '2019-01-13 00:00:00' -e '2019-01-13 23:59:59' --requestType='metadata' --downloadType='received'
 ```

![sw:make:query](/images-docs/sw:make:query-example.png)
