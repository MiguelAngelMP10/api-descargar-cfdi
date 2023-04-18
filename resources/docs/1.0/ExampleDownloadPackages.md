## Download Packages

Este Servicio permite descagar todos los packagesIds de una petición
en la ruta /api-descargar-cfdi/storage/app/datos/{RFC}/packages

### **URL**

```textmate
   POST /api/v1/download-packages
```

### Headers
`Authorization: Bearer {token}` <a href="create_user_and_add_token" target="_blank">pasos para obtener un token</a>

`Accept: application/json`


### **URL Params**

```text
    None
```

### **Data Params**

| Input       | Type          | Required | Values acceptable | Default |        
|-------------|---------------|----------|-------------------|---------|
| cer         | string        | true     |                   |         |
| key         | string        | true     |                   |         |
| password    | string        | true     |                   |         |
| endPoint    | string        | false    | cfdi-retenciones  | cfdi    |
| packagesIds | array of uuid | true     |                   |         |


> {success} Success Response

**Code:** `200`

**Content:**

```json
{
  "errorMessages": [],
  "messages": [
    "El paquete CE4B88D3-7D44-4345-96A9-10F19D570F71_01 se ha almacenado",
    "El paquete E8BC45F4-9DAC-40AF-A116-D8220C373EE5_02 se ha almacenado"
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
    curl --location --request POST 'http://localhost:8000/api/v1/download-packages' \
    --header 'Accept: application/json' \
    --header 'Authorization: Bearer 1|iIGxeYBekhJvXD0C2YYqoAz3tTbsS3lXPL18Mjbg' \
    --form 'cer="-----BEGIN CERTIFICATE-----
    -----END CERTIFICATE-----
    "' \
    --form 'key="-----BEGIN PRIVATE KEY-----
    -----END PRIVATE KEY-----
    "' \
    --form 'password="12345678a"' \
    --form 'endPoint="cfdi"' \
    --form 'packagesIds[]="E8BC45F4-9DAC-40AF-A116-D8220C373EE5_01"' \
    --form 'packagesIds[]="E8BC45F4-9DAC-40AF-A116-D8220C373EE5_02"'
```
