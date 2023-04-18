# Packages

## {rfc}/packages

Reporta los la lista de los paquetes en el almacenamiento local

## **URL**

```textmate
    GET /api/v1/{rfc}/packages
```

### Headers
`Authorization: Bearer {token}` <a href="create_user_and_add_token" target="_blank">pasos para obtener un token</a>

`Accept: application/json`


### **URL Params**

`rfc=[string]`

> {success} Success Response

**Data Params**

None

**Code:** `200`

**Content:**

  ```json
{
    "rfc": "EKU9003173C9",
    "packages": [
        "CE4B88D3-7D44-4345-96A9-10F19D570F71_01"
    ]
}
  ```

> {warning} Unauthorized

**Code:** `401 Unauthorized`

**Content:**

```json
{
    "message": "Unauthenticated."
}
  ```

## **Example Request curl**

```bash
      curl -X GET 'http://localhost:8000/api/v1/EKU9003173C9/packages' \
      -H "Accept: application/json" \
      -H "Authorization: Bearer 1|iIGxeYBekhJvXD0C2YYqoAz3tTbsS3lXPL18Mjbg"
```

![example-rfc-packages](/images-docs/rfc-packages.png)

## GET /{rfc}/packages/{packageId}

Permite obtener un paquete almacenado dado un packageId

## **URL**

```textmate
    GET /api/v1/{rfc}/packages/{packageId}
```

### **URL Params**

`rfc=[string]`

`packageId=[string]`

**Data Params**

None

**Required:**

`rfc=[string]`

`packageId=[string]`


> {success} Success Response

**Code:** `200`

**Content:**

  ```text
    Archivo zip solicitado
  ```

> {warning} Unauthorized

**Code:** `401 Unauthorized`

**Content:**

```json
{
    "message": "Unauthenticated."
}
  ```

## **Example Request curl**

```bash
      curl -X GET 'http://127.0.0.1:8000/api/v1/EKU9003173C9/packages/CE4B88D3-7D44-4345-96A9-10F19D570F71_01' --output filezip.zip \
      -H "Accept: application/json" \
      -H "Authorization: Bearer 1|iIGxeYBekhJvXD0C2YYqoAz3tTbsS3lXPL18Mjbg"
```

![example-GET-{rfc}-packages-{packageId}](/images-docs/GET-%7Brfc%7D-packages-%7BpackageId%7D.png)

## DELETE /{rfc}/packages/{packageId}

Permite eliminar un paquete almacenado local dado un packageId

## **URL**

```textmate
    DELETE /api/v1/{rfc}/packages/{packageId}
```

### **URL Params**

`rfc=[string]`

`packageId=[string]`

**Data Params**

None

**Required:**

`rfc=[string]`

`packageId=[string]`



> {success} Success Response

**Code:** `204`

**Content:**


> {warning} Unauthorized

**Code:** `401 Unauthorized`

**Content:**

```json
{
    "message": "Unauthenticated."
}
  ```

## **Example Request curl**

```bash
      curl -X DELETE 'http://127.0.0.1:8000/api/v1/EKU9003173C9/packages/CE4B88D3-7D44-4345-96A9-10F19D570F71_01' \
      -H "Accept: application/json" \
      -H "Authorization: Bearer 1|iIGxeYBekhJvXD0C2YYqoAz3tTbsS3lXPL18Mjbg"
```
