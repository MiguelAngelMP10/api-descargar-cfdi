# Ejemplos de uso vía cli

* [sw:make:query](../docs/ejemplos_cli.md#swmakequery)
* [sw:verify:query](../docs/ejemplos_cli.md#swverifyquery)
* [sw:download:packages](../docs/ejemplos_cli.md#swdownloadpackages)

Otros comando implementados

* [sw:send:cer-key](../docs/ejemplos_cli.md#swsendcer-key)
* [sw:sync:sat:catalogs](../docs/ejemplos_cli.md#swsyncsatcatalogs)
* [sw:metadata:package:reader](../docs/ejemplos_cli.md#swmetadatapackagereader)


## sw:make:query
### Mostrar ayuda del comando
```bash
  php artisan sw:make:query -h
 ```
![sw:make:query](../docs/img/sw:make:query.png)

### Este comando permite la creación de una consulta ante el servicio web de descarga masiva del sat.

```bash
  php artisan sw:make:query tests/_files/fake-fiel/EKU9003173C9.cer tests/_files/fake-fiel/EKU9003173C9.key -p 12345678a -s '2019-01-13 00:00:00' -e '2019-01-13 23:59:59' --requestType='metadata' --downloadType='received'
 ```
![sw:make:query](../docs/img/sw:make:query-example.png)

## sw:verify:query
### Mostrar ayuda del comando

```bash
  php artisan sw:verify:query -h
 ```
![sw:verify:query](../docs/img/sw:verify:query.png)

### Este comando permite mostrar el estatus de una consulta usando su "requestId"
```bash
  php artisan sw:verify:query tests/_files/fake-fiel/EKU9003173C9.cer tests/_files/fake-fiel/EKU9003173C9.key -p 12345678a --requestId='7e2fe3f0-6086-4308-90b1-e525d2312e31'
 ```

![sw:make:query](../docs/img/sw:verify:query-example.png)

## sw:download:packages
### Mostrar ayuda del comando
```bash
  php artisan sw:download:packages -h
 ```
![sw:download:packages](../docs/img/sw:download:packages.png)

### Comando que permite descargar por lo menos un paquete de cfdis
```bash
  php artisan sw:download:packages  tests/_files/fake-fiel/EKU9003173C9.cer tests/_files/fake-fiel/EKU9003173C9.key -p 12345678a --packageId='7E2FE3F0-6086-4308-90B1-E525D2312E31_01' --pathSave='/home/miguelangelmp10/Descargas/'
 ```
### Resultado
```text
El paquete /home/miguelangelmp10/Descargas/7E2FE3F0-6086-4308-90B1-E525D2312E31_01 se ha almacena
 ```

## sw:send:cer-key
### Comando que permite revisar el estatus de la FIEL
```bash
  php artisan sw:send:cer-key  tests/_files/fake-fiel/EKU9003173C9.cer tests/_files/fake-fiel/EKU9003173C9.key -p 12345678a --copyFiel No
 ```
![sw:send:cer-key](../docs/img/sw:send:cer-key.png)

## sw:sync:sat:catalogs
### Este comando permite la sincronización de catalogos usando phpcfdi/resources-sat-catalogs para proceder a generar la base de datos en el proyecto y generar los modelos de Eloquent.

```bash
  php artisan sw:sync:sat:catalogs
```
![sw:sync:sat:catalogs-1.png](../docs/img/sw:sync:sat:catalogs-1.png)
![sw:sync:sat:catalogs-2.png](../docs/img/sw:sync:sat:catalogs-2.png)

## sw:metadata:package:reader
### Mostrar ayuda del comando
```bash
  php artisan sw:metadata:package:reader -h
```
![sw:metadata:package:reader-h.png](../docs/img/sw:metadata:package:reader-h.png)

### Lectura de archivo de metadata tradicional 
```bash
  php artisan sw:metadata:package:reader tests/_files/metadata_normal.zip
```
![sw:metadata:package:reader-1.png](../docs/img/sw:metadata:package:reader-1.png)
### Lectura de archivo de metadata de retención de pagos

```bash
  php artisan sw:metadata:package:reader tests/_files/metadata_retencion_pagos.zip
```

![sw:metadata:package:reader-2.png](../docs/img/sw:metadata:package:reader-2.png)


