## cfdi-to-json

Este EndPoint convierte archivo(s) CFDI(s) a json

### **URL**

```textmate
    POST /api/v1/cfdi-to-json
```

### Headers

`Authorization: Bearer {token}`

`Accept: application/json`

### **URL Params**

```text
    None
```

### **Data Params**

| Input | Type            | Required | Values acceptable                    | Default |        
|-------|-----------------|----------|--------------------------------------|---------|
| cfdis | array[file.xml] | true     | 'mimetypes:application/xml,text/xml' |         |

> {success} Success Response Aceptada

**Code:** `200`

**Content:**

```json
{
    "Certificado": "MIIGH...imAyX",
    "CondicionesDePago": "CONTADO",
    "Fecha": "2018-01-12T08:15:01",
    "Folio": "11541",
    "FormaPago": "04",
    "LugarExpedicion": "76802",
    "MetodoPago": "PUE",
    "Moneda": "MXN",
    "NoCertificado": "00001000000401220451",
    "Sello": "Xt7tK...gdg==",
    "Serie": "H",
    "SubTotal": "1709.12",
    "TipoDeComprobante": "I",
    "Total": "2010.01",
    "Version": "3.3",
    "xsi:schemaLocation": "http://www.sat.gob.mx/cfd/3 http://www.sat.gob.mx/sitio_internet/cfd/3/cfdv33.xsd http://www.sat.gob.mx/implocal http://www.sat.gob.mx/sitio_internet/cfd/implocal/implocal.xsd",
    "Emisor": {
        "Nombre": "PROMOTORA OTIR SA DE CV",
        "RegimenFiscal": "601",
        "Rfc": "POT9207213D6"
    },
    "Receptor": {
        "Nombre": "DAY INTERNATIONAL DE MEXICO SA DE CV",
        "Rfc": "DIM8701081LA",
        "UsoCFDI": "G03"
    },
    "Conceptos": {
        "Concepto": [
            {
                "Cantidad": "2.00",
                "ClaveProdServ": "90111501",
                "ClaveUnidad": "E48",
                "Descripcion": "Paquete",
                "Importe": "1355.67",
                "Unidad": "UNIDAD DE SERVICIO",
                "ValorUnitario": "677.83",
                "Impuestos": {
                    "Traslados": {
                        "Traslado": [
                            {
                                "Base": "1355.67",
                                "Importe": "216.91",
                                "Impuesto": "002",
                                "TasaOCuota": "0.160000",
                                "TipoFactor": "Tasa"
                            }
                        ]
                    }
                }
            },
            {
                "Cantidad": "1.00",
                "ClaveProdServ": "90101501",
                "ClaveUnidad": "E48",
                "Descripcion": "Restaurante",
                "Importe": "353.45",
                "Unidad": "UNIDAD DE SERVICIO",
                "ValorUnitario": "353.45",
                "Impuestos": {
                    "Traslados": {
                        "Traslado": [
                            {
                                "Base": "353.45",
                                "Importe": "56.55",
                                "Impuesto": "002",
                                "TasaOCuota": "0.160000",
                                "TipoFactor": "Tasa"
                            }
                        ]
                    }
                }
            }
        ]
    },
    "Impuestos": {
        "TotalImpuestosTrasladados": "273.46",
        "Traslados": {
            "Traslado": [
                {
                    "Importe": "273.46",
                    "Impuesto": "002",
                    "TasaOCuota": "0.160000",
                    "TipoFactor": "Tasa"
                }
            ]
        }
    },
    "Complemento": [
        {
            "ImpuestosLocales": {
                "TotaldeRetenciones": "0.00",
                "TotaldeTraslados": "27.43",
                "version": "1.0",
                "TrasladosLocales": [
                    {
                        "ImpLocTrasladado": "IH",
                        "Importe": "27.43",
                        "TasadeTraslado": "2.50"
                    }
                ]
            },
            "TimbreFiscalDigital": {
                "FechaTimbrado": "2018-01-12T08:17:54",
                "NoCertificadoSAT": "00001000000406258094",
                "RfcProvCertif": "DCD090706E42",
                "SelloCFD": "Xt7tK...gdg==",
                "SelloSAT": "IRy7w...6Zg==",
                "UUID": "CEE4BE01-ADFA-4DEB-8421-ADD60F0BEDAC",
                "Version": "1.1",
                "xsi:schemaLocation": "http://www.sat.gob.mx/TimbreFiscalDigital http://www.sat.gob.mx/sitio_internet/cfd/TimbreFiscalDigital/TimbreFiscalDigitalv11.xsd"
            }
        }
    ]
}
```

> {warning} Unauthorized

**Code:** `401 Unauthorized`

**Content:**

```json
{
    "message": "Unauthenticated."
}
```


## **Example Request curl**

```bash
curl --location --request POST 'http://127.0.0.1:8000/api/v1/cfdi-to-json' \
  --header 'Accept: application/json' \
  --header 'Authorization: Bearer 2|RB9dtSiawoH3pqNqzgwpvnUkySrTFhVF1vLwoyFO' \
  --form 'cfdis[]=@"/home/miguelangelmp10/Documentos/api-descargar-cfdi/tests/_files/cfdis/cfdi-example.xml"'
```
