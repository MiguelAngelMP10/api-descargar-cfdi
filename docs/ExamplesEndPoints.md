# Examples in Curl

## Send cer and key

Reporta los path de las los archivos .cer y .key

-   **URL**

    `/api/v1/send-cer-key`

-   **Method:**

    `POST`

-   **URL Params**

    None

-   **Data Params**

    **Required:**

    -   `cer=[file.cer]`
    -   `key=[file.key]`
    -   `password=[string]`

-   **Success Response:**

    **Code:** 200

    **Content:**

    ```json
    {
        "pathCer": "datos/EKU9003173C9/EKU9003173C9.cer",
        "pathKey": "datos/EKU9003173C9/EKU9003173C9.key"
    }
    ```

<!--
* **Error Response:**

  * **Code:** 404 NOT FOUND <br />
    **Content:** `{ error : "User doesn't exist" }`

  OR

  * **Code:** 401 UNAUTHORIZED <br />
    **Content:** `{ error : "You are unauthorized to make this request." }`

 -->

-   **Example**

    ```bash
    curl -X POST 'http://localhost:8000/api/v1/send-cer-key' \
     --form 'cer=@tests/_files/fake-fiel/EKU9003173C9.cer' \
     --form 'key=@tests/_files/fake-fiel/EKU9003173C9.key' \
     --form 'password=12345678a'
    ```

## Make query

Reporta

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

     <!--
      - POST
      - POST /api/v1/verify-query
      - POST /api/v1/download-packages
      - GET /api/v1/packages/{rfc}
      - GET /api/v1/packages/{rfc}/{packageId}
      - DELETE /api/v1/packages/{rfc}/{packageId}
    ````
    
    -->
