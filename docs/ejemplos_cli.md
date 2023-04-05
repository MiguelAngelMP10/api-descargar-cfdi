# Ejemplos de uso vía cli

* [sw:make:query](../docs/ejemplos_cli.md#swmakequery)
* [sw:verify:query](../docs/ejemplos_cli.md#swverifyquery)
* [sw:download:packages](../docs/ejemplos_cli.md#swdownloadpackages)

Otros comando implementados

* [sw:send:cer-key](../docs/ejemplos_cli.md#swsendcer-key)
* [sw:sync:sat:catalogs](../docs/ejemplos_cli.md#swsyncsatcatalogs)
* [sw:metadata:package:reader](../docs/ejemplos_cli.md#swmetadatapackagereader)


## sw:make:query
```bash
  php artisan sw:make:query -h
 ```
![sw:make:query](../docs/img/sw:make:query.png)

```bash
  php artisan sw:make:query tests/_files/fake-fiel/EKU9003173C9.cer tests/_files/fake-fiel/EKU9003173C9.key -p 12345678a -s '2019-01-13 00:00:00' -e '2019-01-13 23:59:59' --requestType='metadata' --downloadType='received'
 ```
![sw:make:query](../docs/img/sw:make:query-example.png)

## sw:verify:query

```bash
  php artisan sw:verify:query -h
 ```
![sw:verify:query](../docs/img/sw:verify:query.png)


```bash
  php artisan sw:verify:query tests/_files/fake-fiel/EKU9003173C9.cer tests/_files/fake-fiel/EKU9003173C9.key -p 12345678a --requestId='7e2fe3f0-6086-4308-90b1-e525d2312e31'
 ```
![sw:make:query](../docs/img/sw:verify:query-example.png)

## sw:download:packages

```bash
  php artisan sw:download:packages -h
 ```
![sw:download:packages](../docs/img/sw:download:packages.png)


```bash
  php artisan sw:download:packages  tests/_files/fake-fiel/EKU9003173C9.cer tests/_files/fake-fiel/EKU9003173C9.key -p 12345678a --packageId='7E2FE3F0-6086-4308-90B1-E525D2312E31_01' --pathSave='/home/miguelangelmp10/Descargas/'
 ```
Resultado
```text
El paquete /home/miguelangelmp10/Descargas/7E2FE3F0-6086-4308-90B1-E525D2312E31_01 se ha almacena
 ```

## sw:send:cer-key

## sw:sync:sat:catalogs

## sw:metadata:package:reader
