## Make query

    Retorna un json con "message, code y requestId" si se realizó de forma correcta la consulta.

-   **URL**

    `POST /api/v1/make-query`

-   **URL Params**

    None

-   **Data Params**

    **Required:**

    -   `RFC=[string required]`
    -   `password=[string required]`
    -   `period=[{"start":"2021-01-01 00:00:00", "end":"2021-01-30 23:59:59" }] required`
    -   `retenciones=[boolean] required`
    -   `downloadType=[string: issued|received] required`
    -   `requestType=[string: xml|metadata] required`
    -   `rfcMatch=[array > string]`
    -   `documentType=[string: I|E|N|T|P]`
    -   `complementoCfdi=[string]`
      - Valores posibles para complementoCfdi
    
        |ComplementoCfdi|Etiqueta|
        | ------------- | ------ |
        |''|'Sin complemento definido'|
        |'acreditamientoIeps10'|'Acreditamiento del IEPS 1.0'|
        |'aerolineas10'|'Aerolíneas 1.0'|
        |'certificadoDestruccion10'|'Certificado de destrucción 1.0'|
        |'cfdiRegistroFiscal10'|'CFDI Registro fiscal 1.0'|
        |'comercioExterior10'|'Comercio Exterior 1.0'|
        |'comercioExterior11'|'Comercio Exterior 1.1'|
        |'consumoCombustibles10'|'Consumo de combustibles 1.0'|
        |'consumoCombustibles11'|'Consumo de combustibles 1.1'|
        |'detallista'|'Detallista'|
        |'divisas10'|'Divisas 1.0'|
        |'donatarias11'|'Donatarias 1.1'|
        |'estadoCuentaCombustibles11'|'Estado de cuenta de combustibles 1.1'|
        |'estadoCuentaCombustibles12'|'Estado de cuenta de combustibles 1.2'|
        |'gastosHidrocarburos10'|'Gastos Hidrocarburos 1.0'|
        |'institucionesEducativasPrivadas10'|'Instituciones educativas privadas 1.0'|
        |'impuestosLocales10'|'Impuestos locales 1.0'|
        |'ine11'|'INE 1.1'|
        |'ingresosHidrocarburos10'|'Ingresos Hidrocarburos 1.0'|
        |'leyendasFiscales10'|'Leyendas Fiscales 1.0'|
        |'nomina11'|'Nómina 1.1'|
        |'nomina12'|'Nómina 1.2'|
        |'notariosPublicos10'|'Notarios públicos 1.0'|
        |'obrasArtePlasticasYAntiguedades10'|'Obras de arte plásticas y antigüedades 1.0'|
        |'pagoEnEspecie10'|'Pago en especie 1.0'|
        |'recepcionPagos10'|'Recepción de pagos 1.0'|
        |'personaFisicaIntegranteCoordinado10'|'Persona física integrante de coordinado 1.0'|
        |'renovacionYSustitucionVehiculos10'|'Renovación y sustitución de vehículos 1.0'|
        |'serviciosParcialesConstruccion10'|'Servicios parciales de construcción 1.0'|
        |'spei'|'SPEI'|
        |'terceros11'|'Terceros 1.1'|
        |'turistaPasajeroExtranjero10'|'Turista pasajero extranjero 1.0'|
        |'valesDespensa10'|'Vales de despensa 1.0'|
        |'vehiculoUsado10'|'Vehículo usado 1.0'|
        |'ventaVehiculos11'|'Venta de vehículos 1.1'|
    
    -   `documentStatus=[string: active|cancelled]`
    -   `uuid=[uuid]`


-   **Success Response:**

    **Code:** 200

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

    -   **Error Response:**

*   **Code:** 404 NOT FOUND <br />
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

  -   **Example**

      ```bash
      curl  -X POST 'http://127.0.0.1:8000/api/v1/make-query' \
      --header 'Accept: application/json' \
      --header 'Authorization: Bearer 1|iIGxeYBekhJvXD0C2YYqoAz3tTbsS3lXPL18Mjbg' \
      --header 'Content-Type: application/json' \
      --data-raw '{
          "RFC": "EKU9003173C9",
          "password": "12345678a",
          "period": { "start": "2021-11-01 00:00:01",
          "end": "2021-12-31 23:59:59" },
          "retenciones": false,
          "downloadType": "received",
          "requestType": "metadata",
          "documentType": "",
          "rfcMatch": [],
          "complementoCfdi": "leyendasfisc",
          "documentStatus": "active",
          "uuid": "ace229af-ea82-4e3f-b2b1-816d11c7b86a" }'
      ```
