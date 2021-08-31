## Verify Query

Ejemplo en construcción 

-   **URL**

    `POST /api/v1/download-packages`

-   **URL Params**

    None

-   **Data Params**

    **Required:**

    -   `name=[tipo]`

-   **Success Response:**

    **Code:** 200

    **Content:**

    ```json
    {
       
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
    curl -X POST 'http://localhost:8000/' 
    ```
