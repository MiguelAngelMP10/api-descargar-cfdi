
# Examples in Curl 

##  Send cer and key

 Reporta los path de las los archivos .cer y .key

* **URL**

  /api/v1/send-cer-key
  
* **Method:**

  `POST`
  
*  **URL Params**
    
    None

* **Data Params**

   **Required:**

    - `cer=[.cer]`
    - `key=[.key]`
    - `password=[string]`
  
* **Success Response:**

    **Code:** 200 

    **Content:** 
    ```json
    {
        "pathCer":"datos/EKU9003173C9/EKU9003173C9.cer",
        "pathKey":"datos/EKU9003173C9/EKU9003173C9.key"
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

* **Example**

  ```bash
  curl -X POST 'http://localhost:8000/api/v1/send-cer-key' \
   --form 'cer=@tests/_files/fake-fiel/EKU9003173C9.cer' \
   --form 'key=@tests/_files/fake-fiel/EKU9003173C9.key' \
   --form 'password=12345678a'
  ```




   <!-- ```
    - POST /api/v1/make-query
    - POST /api/v1/verify-query
    - POST /api/v1/download-packages
    - GET /api/v1/packages/{rfc}
    - GET /api/v1/packages/{rfc}/{packageId}
    - DELETE /api/v1/packages/{rfc}/{packageId}
    ``` -->
