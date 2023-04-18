# sw:verify:query

Este comando permite mostrar el estatus de una consulta usando su "requestId"

## Mostrar ayuda del comando

```bash
  php artisan sw:verify:query -h
 ```

![sw:verify:query](/images-docs/sw:verify:query.png)

## Ejemplo de uso

```bash
  php artisan sw:verify:query tests/_files/fake-fiel/EKU9003173C9.cer tests/_files/fake-fiel/EKU9003173C9.key -p 12345678a --requestId='7e2fe3f0-6086-4308-90b1-e525d2312e31'
 ```

![sw:make:query](/images-docs/sw:verify:query-example.png)
