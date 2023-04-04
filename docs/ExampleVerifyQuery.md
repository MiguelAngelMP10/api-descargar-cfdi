## Verify Query

Este EndPoint 
-   **URL**

    `POST /api/v1/verify-query`

-   **URL Params**

    None

-   **Data Params**

    **Required:**

    - `RFC=[string]`
    - `password=[string]`
    - `requestId=[string]`
    - `retenciones=[boolean] required`
    

-   **Success Response:**

    **Code:** 200

    **Content:**

    ```json
        {
            "status": {
                "code": 5000,
                "message": "Solicitud Aceptada"
            },
            "codeRequest": {
                "value": 5000,
                "message": "Solicitud recibida con éxito"
            },
            "statusRequest": {
                "value": 1,
                "message": "Aceptada"
            },
            "numberCfdis": 0,
            "packagesIds": []
        }
    ```


* **Error Response:**

  * **Code:** 401 Unauthorized <br />
    **Content:** 
    ```bash
        {
            "message": "Unauthenticated."
        }
     ```

    -   **Example**

        ```bash
        curl -X POST 'http://localhost:8000/api/v1/verify-query' \
        --header 'Accept: application/json' \
        --header 'Authorization: Bearer 1|iIGxeYBekhJvXD0C2YYqoAz3tTbsS3lXPL18Mjbg' \
        --header 'Content-Type: application/json' \
        --data-raw '{
           "RFC": "EKU9003173C9",
           "password": "12345678a",
            "requestId": "9f25a41a-19d9-409d-927a-87238f006292",
            "retenciones": false
        }'
        ```
