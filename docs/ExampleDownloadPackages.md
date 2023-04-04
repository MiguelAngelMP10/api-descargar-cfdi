## Download Packages

Este Servicio permite descagar todos los packagesIds de una petición

-   **URL**

    `POST /api/v1/download-packages`

-   **URL Params**

    None

-   **Data Params**

    **Required:**

    - `RFC=[string] required`
    - `password=[string] required`
    - `retenciones=[boolean] required`
    - `packagesIds=[array -> string]`

  -   **Success Response:**

      **Code:** 200

      **Content:**

      ```json
      {
      "errorMessages": [],
      "messages": [
          "El paquete CE4B88D3-7D44-4345-96A9-10F19D570F71_01 se ha almacenado"
        ]
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

    -   **Example Request**

        ```bash
        curl -X POST 'http://localhost:8000/api/v1/download-packages' \
        --header 'Accept: application/json' \
        --header 'Authorization: Bearer 1|iIGxeYBekhJvXD0C2YYqoAz3tTbsS3lXPL18Mjbg' \
        --header 'Content-Type: application/json' \
        --data-raw '{
        "RFC": "EKU9003173C9",
        "password": "12345678a",
        "retenciones": false,
        "packagesIds": [
                "CE4B88D3-7D44-4345-96A9-10F19D570F71_01"
            ]
        }' 
        ```
