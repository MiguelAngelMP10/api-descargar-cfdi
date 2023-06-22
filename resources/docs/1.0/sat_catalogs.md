# SAT catalogs

- [Comercio Exterior](#comercio-exterior)
- [Complemento Carta Porte](#complemento-carta-porte)
- [CFDI 4.0](#CFDI-40)
- [CFDI 3.3](#CFDI-33)
- [Complemento de recibo de pago de nómina](#nomina)
- [Complemento de recibo electrónico de pagos](#pagos)
- [CFDI De Retenciones e Información de Pagos](#ret_20)

<a name="comercio-exterior"></a>

## [Comercio Exterior](#comercio-exterior)

### cce_claves_pedimentos

### **URL**
#### Obtiene todos los registros

```textmate
    GET /api/v1/catalogs/cce-claves-pedimentos 
```

### Headers

`Authorization: Bearer {token}`

`Accept: application/json`

### **URL Params**

```text
    None
```

### **Data Params**

```text
    None
```

> {success} Success Response

**Code:** `200`

**Content:**

```json
{
    "data": [
        {
            "id": "A1",
            "texto": "IMPORTACION O EXPORTACION DEFINITIVA"
        }
    ],
    "links": {
        "first": "http://127.0.0.1/api/v1/catalogs/cce-claves-pedimentos?page=1",
        "last": "http://127.0.0.1/api/v1/catalogs/cce-claves-pedimentos?page=1",
        "prev": null,
        "next": null
    },
    "meta": {
        "current_page": 1,
        "from": 1,
        "last_page": 1,
        "links": [
            {
                "url": null,
                "label": "&laquo; Previous",
                "active": false
            },
            {
                "url": "http://127.0.0.1/api/v1/catalogs/cce-claves-pedimentos?page=1",
                "label": "1",
                "active": true
            },
            {
                "url": null,
                "label": "Next &raquo;",
                "active": false
            }
        ],
        "path": "http://127.0.0.1/api/v1/catalogs/cce-claves-pedimentos",
        "per_page": 15,
        "to": 1,
        "total": 1
    }
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
curl --location --request GET 'http://127.0.0.1/api/v1/catalogs/cce-claves-pedimentos' \
--header 'Accept: application/json' \
--header 'Authorization: Bearer 4|Nvffn5yGkKGswnwZDfn9bbODLnVJ9DMgZozKsi04'
```


### **URL**
#### Obtiene un elemento dado un id

```textmate
    GET /api/v1/catalogs/cce-claves-pedimentos/{cce_claves_pedimento}
```

### Headers

`Authorization: Bearer {token}`

`Accept: application/json`

### **URL Params**

```text
    {cce_claves_pedimento}
```

### **Data Params**

```text
    None
```

> {success} Success Response

**Code:** `200`

**Content:**

```json
{
  "data": {
    "id": "A1",
    "texto": "IMPORTACION O EXPORTACION DEFINITIVA"
  }
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
curl --location --request GET 'http://127.0.0.1/api/v1/catalogs/cce-claves-pedimentos/A1' \
--header 'Accept: application/json' \
--header 'Authorization: Bearer 4|Nvffn5yGkKGswnwZDfn9bbODLnVJ9DMgZozKsi04'
```



### cce_colonias

### cce_estados

### cce_fracciones_arancelarias

### cce_incoterms

### cce_localidades

### cce_motivos_traslado

### cce_municipios

### cce_tipos_operacion

### cce_unidades_medida

<a name="complemento-carta-porte"></a>

## [Complemento Carta Porte](#complemento-carta-porte)

### ccp_20_autorizaciones_naviero

### ccp_20_claves_unidades

### ccp_20_codigos_transporte_aereo

### ccp_20_colonias

### ccp_20_configuraciones_autotransporte

### ccp_20_configuraciones_maritimas

### ccp_20_contenedores

### ccp_20_contenedores_maritimos

### ccp_20_derechos_de_paso

### ccp_20_estaciones

### ccp_20_figuras_transporte

### ccp_20_localidades

### ccp_20_materiales_peligrosos

### ccp_20_municipios

### ccp_20_partes_transporte

### ccp_20_productos_servicios

### ccp_20_tipos_carga

### ccp_20_tipos_carro

### ccp_20_tipos_embalaje

### ccp_20_tipos_estacion

### ccp_20_tipos_permiso

### ccp_20_tipos_remolque

### ccp_20_tipos_servicio

### ccp_20_tipos_trafico

### ccp_20_transportes

<a name="CFDI-40"></a>

## [CFDI 4.0](#CFDI-40)

### cfdi_40_aduanas

### cfdi_40_claves_unidades

### cfdi_40_codigos_postales

### cfdi_40_colonias

### cfdi_40_estados

### cfdi_40_exportaciones

### cfdi_40_formas_pago

### cfdi_40_impuestos

### cfdi_40_localidades

### cfdi_40_meses

### cfdi_40_metodos_pago

### cfdi_40_monedas

### cfdi_40_municipios

### cfdi_40_numeros_pedimento_aduana

### cfdi_40_objetos_impuestos

### cfdi_40_paises

### cfdi_40_patentes_aduanales

### cfdi_40_periodicidades

### cfdi_40_productos_servicios

### cfdi_40_regimenes_fiscales

### cfdi_40_reglas_tasa_cuota

### cfdi_40_tipos_comprobantes

### cfdi_40_tipos_factores

### cfdi_40_tipos_relaciones

### cfdi_40_usos_cfdi

<a name="CFDI-33"></a>

## [CFDI 3.3](#CFDI-33)

### cfdi_aduanas

### cfdi_claves_unidades

### cfdi_codigos_postales

### cfdi_formas_pago

### cfdi_impuestos

### cfdi_metodos_pago

### cfdi_monedas

### cfdi_numeros_pedimento_aduana

### cfdi_paises

### cfdi_patentes_aduanales

### cfdi_productos_servicios

### cfdi_regimenes_fiscales

### cfdi_reglas_tasa_cuota

### cfdi_tipos_comprobantes

### cfdi_tipos_factores

### cfdi_tipos_relaciones

### cfdi_usos_cfdi

<a name="nomina"></a>

## [Complemento de recibo de pago de nómina](#nomina)

### nomina_bancos

### nomina_estados

### nomina_origenes_recursos

### nomina_periodicidades_pagos

### nomina_riesgos_puestos

### nomina_tipos_contratos

### nomina_tipos_deducciones

### nomina_tipos_horas

### nomina_tipos_incapacidades

### nomina_tipos_jornadas

### nomina_tipos_nominas

### nomina_tipos_otros_pagos

### nomina_tipos_percepciones

### nomina_tipos_regimenes

<a name="pagos"></a>

## [Complemento de recibo electrónico de pagos](#pagos)

### pagos_tipos_cadena_pago

<a name="ret_20"></a>

## [CFDI De Retenciones e Información de Pagos](#ret_20)

### ret_20_claves_retencion

### ret_20_ejercicios

### ret_20_entidades_federativas

### ret_20_paises

### ret_20_periodicidades

### ret_20_periodos

### ret_20_tipos_contribuyentes

### ret_20_tipos_dividendos_utilidades

### ret_20_tipos_impuestos

### ret_20_tipos_pago_retencion
