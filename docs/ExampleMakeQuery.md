## Make query

    Retorna un json con "message, code y requestId" si se realizó de forma correcta la consulta.

-   **URL**

    `POST /api/v1/make-query`

-   **URL Params**

    None

-   **Data Params**

    **Required:**

    -   `RFC=[string]`
    -   `password=[string]`
    -   `period=[{"start":"2021-01-01 00:00:00", "end":"2021-01-30 23:59:59" }]`
    -   `retenciones=[boolean]`
    -   `downloadType=[string: issued|received]`
    -   `requestType=[string: cfdi|metadata]`
    -   `rfcMatch=[string]`

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
    curl -X POST "http://localhost:8000/api/v1/make-query"  \
    -H "Authorization: Bearer 1|YTAe4YrL5btDvR5LdKRLcdsRgP0p3VQGaWPfvs8a"
    -H "Content-Type: application/json"  \
    --data-raw '{
      "RFC": "RFCSolicitante",
      "password": "password",
      "period": {
          "start": "2021-08-01 00:00:00",
          "end": "2021-08-15 23:59:59"
      },
      "retenciones": false,
      "downloadType": "received",
      "requestType": "metadata",
      "rfcMatch": ""
    }'
    ```
