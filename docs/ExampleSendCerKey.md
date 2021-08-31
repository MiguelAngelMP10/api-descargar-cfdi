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

*   **Errors Response:**

    -   **Code:** 422 UNPROCESSABLE ENTITY

        **Content:**

        ```json
        {
            "message": "Los datos enviados de certificado, llave privada o contraseña son inválidos.",
            "errors": {
                "password": ["The password field is required."],
                "key": ["The key field is required."],
                "cer": ["The cer field is required."]
            }
        }
        ```

        -   **Code:** 422 UNPROCESSABLE ENTITY

        **Content:**

        ```json
        {
            "message": "Certificado, llave privada o contraseña inválida",
            "code": "Cannot open private key: error:06065064:digital envelope routines:EVP_DecryptFinal_ex:bad decrypt"
        }
        ```

-   **Example**
    ```bash
        curl -X POST 'http://localhost:8000/api/v1/send-cer-key' \
        --form 'cer=@tests/_files/fake-fiel/EKU9003173C9.cer' \
        --form 'key=@tests/_files/fake-fiel/EKU9003173C9.key' \
        --form 'password=12345678a' \
        -H "Accept: application/json" \
        -H "Authorization: Bearer 1|YTAe4YrL5btDvR5LdKRLcdsRgP0p3VQGaWPfvs8a"
    ```
