
# sw:download:packages

Comando que permite descargar por lo menos un paquete de cfdis

## Mostrar ayuda del comando

```bash
  php artisan sw:download:packages -h
 ```
![sw:download:packages](/images-docs/sw:download:packages.png)

## Ejemplo de uso
```bash
  php artisan sw:download:packages  tests/_files/fake-fiel/EKU9003173C9.cer tests/_files/fake-fiel/EKU9003173C9.key -p 12345678a --packageId='7E2FE3F0-6086-4308-90B1-E525D2312E31_01' --pathSave='/home/miguelangelmp10/Descargas/'
 ```
### Resultado
```text
El paquete /home/miguelangelmp10/Descargas/7E2FE3F0-6086-4308-90B1-E525D2312E31_01 se ha almacena
 ```


