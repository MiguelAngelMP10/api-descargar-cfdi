## Send cer and key

Reporta los path de los archivos .cer y .key

-   **URL**

    `POST /api/v1/send-cer-key`

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


* **Error Response:**

  * **Code:** 404 NOT FOUND <br />
    **Content:** 
    ```bash
        { error : "User doesn't exist" }
     ```

-   **Example**

    ```bash
    curl -X POST 'http://localhost:8000/api/v1/send-cer-key' \
     --form 'cer=@tests/_files/fake-fiel/EKU9003173C9.cer' \
     --form 'key=@tests/_files/fake-fiel/EKU9003173C9.key' \
     --form 'password=12345678a'
    ```
