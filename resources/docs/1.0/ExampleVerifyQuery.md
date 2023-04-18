## Verify Query

Este EndPoint verifica el estatus de una consulta dada un requestId

### **URL**

```textmate
    POST /api/v1/verify-query
```

### Headers
`Authorization: Bearer {token}` <a href="create_user_and_add_token" target="_blank">pasos para obtener un token</a>

`Accept: application/json`


### **URL Params**

```text
    None
```

### **Data Params**

| Input     | Type   | Required | Values acceptable | Default |        
|-----------|--------|----------|-------------------|---------|
| cer       | string | true     |                   |         |
| key       | string | true     |                   |         |
| password  | string | true     |                   |         |
| endPoint  | string | false    | cfdi-retenciones  | cfdi    |
| requestId | uuid   | true     |                   |         |

> {success} Success Response Aceptada

**Code:** `200`

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

> {success} Success Response Terminada

**Code:** `200`

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
        "value": 3,
        "message": "Terminada"
    },
    "numberCfdis": 115,
    "packagesIds": [
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
    curl --location --request POST 'http://127.0.0.1:8000/api/v1/verify-query' \
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
    --form 'requestId="e8bc45f4-9dac-40af-a116-d8220c373ee5"'
```
