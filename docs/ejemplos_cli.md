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

## sw:download:packages

## sw:send:cer-key

## sw:sync:sat:catalogs

## sw:metadata:package:reader
