## Make query

    Retorna un json con "message, code y requestId" si se realizó de forma correcta la consulta.

### **URL**

```textmate
    POST /api/v1/make-query
```

### Headers
`Authorization: Bearer {token}` <a href="create_user_and_add_token" target="_blank">pasos para obtener un token</a>

`Accept: application/json`


### **URL Params**

```text
    None
```

### **Data Params**

| Input           | Type             | Required | Values acceptable                                          | Default                                                                           |        
|-----------------|------------------|----------|------------------------------------------------------------|-----------------------------------------------------------------------------------|
| cer             | string           | true     |                                                            |                                                                                   |
| key             | string           | true     |                                                            |                                                                                   |
| password        | string           | true     |                                                            |                                                                                   |
| period[start]   | date             | false    |                                                            | Si no se especifica crea un periodo del segundo exacto de la creación del objeto. |
| period[end]     | date             | false    |                                                            | Si no se especifica crea un periodo del segundo exacto de la creación del objeto. |
| endPoint        | string           | false    | cfdi-retenciones                                           | cfdi                                                                              |
| downloadType    | string           | false    | issued-received                                            | issued                                                                            |
| requestType     | string           | false    | xml-metadata                                               | metadata                                                                          |
| documentType    | string           | false    | `I-E-N-T-P`                                                | ''                                                                                |
| documentStatus  | string           | false    | active-cancelled                                           | ''                                                                                |
| complementoCfdi | string           | false    | [Valores posibles](#valores-posibles-para-complementocfdi) |                                                                                   |
| rfcMatches      | array of strings | false    |                                                            |                                                                                   |
| uuid            | uuid             | false    |                                                            |                                                                                   |

> {success} Success Response

**Code:** `200`

**Content:**

  ```json
  {
    "message": "Solicitud Aceptada",
    "code": {
        "code": 5000,
        "message": "Solicitud Aceptada"
    },
    "requestId": "9d4aa78c-7bce-4511-9cca-5d09a8a2bdfc"
}
  ```

> {danger} Error Response

**Code:** `404 NOT FOUND`

**Content:**

  ```json
  {
    "message": "Certificado Inválido",
    "code": {
        "code": 305,
        "message": "Certificado Inválido"
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
      curl --location --request POST 'http://127.0.0.1:8000/api/v1/make-query' \
      --header 'Accept: application/json' \
      --header 'Authorization: Bearer 1|iIGxeYBekhJvXD0C2YYqoAz3tTbsS3lXPL18Mjbg' \
      --form 'cer="-----BEGIN CERTIFICATE-----
      -----END CERTIFICATE-----"' \
      --form 'key="-----BEGIN PRIVATE KEY-----
      -----END PRIVATE KEY-----"' \
      --form 'password="12345678a"' \
      --form 'period[start]="2022-01-01 00:00:00"' \
      --form 'period[end]="2022-12-31 23:59:59"' \
      --form 'downloadType="received"' \
      --form 'requestType="metadata"' \
      --form 'documentType="N"' \
      --form 'complementoCfdi="acreditamientoieps10"' \
      --form 'documentStatus="active"' \
      --form 'uuid="c4ee9b76-5c33-4c63-b63c-498cd956bd48"' \
      --form 'rfcOnBehalf="CUPU800825569"' \
      --form 'rfcMatches[]="CUPU800825569"' \
      --form 'rfcMatches[]="CUPU800825562"'
```

### Valores posibles para complementoCfdi

| ComplementoCfdi                       | Etiqueta                                      |
|---------------------------------------|-----------------------------------------------|
| ''                                    | 'Sin complemento definido'                    |
| 'acreditamientoIeps10'                | 'Acreditamiento del IEPS 1.0'                 |
| 'aerolineas10'                        | 'Aerolíneas 1.0'                              |
| 'certificadoDestruccion10'            | 'Certificado de destrucción 1.0'              |
| 'cfdiRegistroFiscal10'                | 'CFDI Registro fiscal 1.0'                    |
| 'comercioExterior10'                  | 'Comercio Exterior 1.0'                       |
| 'comercioExterior11'                  | 'Comercio Exterior 1.1'                       |
| 'consumoCombustibles10'               | 'Consumo de combustibles 1.0'                 |
| 'consumoCombustibles11'               | 'Consumo de combustibles 1.1'                 |
| 'detallista'                          | 'Detallista'                                  |
| 'divisas10'                           | 'Divisas 1.0'                                 |
| 'donatarias11'                        | 'Donatarias 1.1'                              |
| 'estadoCuentaCombustibles11'          | 'Estado de cuenta de combustibles 1.1'        |
| 'estadoCuentaCombustibles12'          | 'Estado de cuenta de combustibles 1.2'        |
| 'gastosHidrocarburos10'               | 'Gastos Hidrocarburos 1.0'                    |
| 'institucionesEducativasPrivadas10'   | 'Instituciones educativas privadas 1.0'       |
| 'impuestosLocales10'                  | 'Impuestos locales 1.0'                       |
| 'ine11'                               | 'INE 1.1'                                     |
| 'ingresosHidrocarburos10'             | 'Ingresos Hidrocarburos 1.0'                  |
| 'leyendasFiscales10'                  | 'Leyendas Fiscales 1.0'                       |
| 'nomina11'                            | 'Nómina 1.1'                                  |
| 'nomina12'                            | 'Nómina 1.2'                                  |
| 'notariosPublicos10'                  | 'Notarios públicos 1.0'                       |
| 'obrasArtePlasticasYAntiguedades10'   | 'Obras de arte plásticas y antigüedades 1.0'  |
| 'pagoEnEspecie10'                     | 'Pago en especie 1.0'                         |
| 'recepcionPagos10'                    | 'Recepción de pagos 1.0'                      |
| 'personaFisicaIntegranteCoordinado10' | 'Persona física integrante de coordinado 1.0' |
| 'renovacionYSustitucionVehiculos10'   | 'Renovación y sustitución de vehículos 1.0'   |
| 'serviciosParcialesConstruccion10'    | 'Servicios parciales de construcción 1.0'     |
| 'spei'                                | 'SPEI'                                        |
| 'terceros11'                          | 'Terceros 1.1'                                |
| 'turistaPasajeroExtranjero10'         | 'Turista pasajero extranjero 1.0'             |
| 'valesDespensa10'                     | 'Vales de despensa 1.0'                       |
| 'vehiculoUsado10'                     | 'Vehículo usado 1.0'                          |
| 'ventaVehiculos11'                    | 'Venta de vehículos 1.1'                      |

