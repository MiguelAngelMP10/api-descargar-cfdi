## Make query

    Retorna 

-   **URL**

    `/api/v1/make-query`

-   **Method:**

    `POST`

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

    * **Error Response:**

  * **Code:** 404 NOT FOUND <br />
    **Content:** 
    ```bash
        { error : "" }
     ```


-   **Example**

    ```bash
    curl -X POST "http://localhost:8000/api/v1/make-query" -H "Content-Type: application/json" --data-raw '{
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
