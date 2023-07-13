## Make query

    Retorna un json con "message, code y requestId" si se realizó de forma correcta la consulta.

### **URL**

```textmate
    POST /api/v1/make-query
```

### Headers

`Authorization: Bearer {token}` <a href="create_user_and_add_token" target="_blank">pasos para obtener un token</a>

`Accept: application/json`

### **URL Params**

```text
    None
```

### **Data Params**

| Input           | Type             | Required | Values acceptable                                                                                                                                      | Default                                                                           |        
|-----------------|------------------|----------|--------------------------------------------------------------------------------------------------------------------------------------------------------|-----------------------------------------------------------------------------------|
| cer             | string           | true     |                                                                                                                                                        |                                                                                   |
| key             | string           | true     |                                                                                                                                                        |                                                                                   |
| password        | string           | true     |                                                                                                                                                        |                                                                                   |
| period[start]   | date             | false    |                                                                                                                                                        | Si no se especifica crea un periodo del segundo exacto de la creación del objeto. |
| period[end]     | date             | false    |                                                                                                                                                        | Si no se especifica crea un periodo del segundo exacto de la creación del objeto. |
| endPoint        | string           | false    | cfdi-retenciones                                                                                                                                       | cfdi                                                                              |
| downloadType    | string           | false    | issued-received                                                                                                                                        | issued                                                                            |
| requestType     | string           | false    | xml-metadata                                                                                                                                           | metadata                                                                          |
| documentType    | string           | false    | `I-E-N-T-P`                                                                                                                                            | ''                                                                                |
| documentStatus  | string           | false    | active-cancelled                                                                                                                                       | ''                                                                                |
| complementoCfdi | string           | false    | [Complements of cfdi](/{{route}}/{{version}}/complements_of_cfdi)<br/><br/>[Complements of retention](/{{route}}/{{version}}/complements_of_retention) |                                                                                   |
| rfcMatches      | array of strings | false    |                                                                                                                                                        |                                                                                   |
| uuid            | uuid             | false    |                                                                                                                                                        |                                                                                   |

> {success} Success Response

**Code:** `200`

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

> {danger} Error Response

**Code:** `404 NOT FOUND`

**Content:**

  ```json
  {
    "message": "Certificado Inválido",
    "code": {
        "code": 305,
        "message": "Certificado Inválido"
    }
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
      curl --location --request POST 'http://127.0.0.1:8000/api/v1/make-query' \
      --header 'Accept: application/json' \
      --header 'Authorization: Bearer 1|iIGxeYBekhJvXD0C2YYqoAz3tTbsS3lXPL18Mjbg' \
      --form 'cer="-----BEGIN CERTIFICATE-----
      -----END CERTIFICATE-----"' \
      --form 'key="-----BEGIN PRIVATE KEY-----
      -----END PRIVATE KEY-----"' \
      --form 'password="12345678a"' \
      --form 'period[start]="2022-01-01 00:00:00"' \
      --form 'period[end]="2022-12-31 23:59:59"' \
      --form 'downloadType="received"' \
      --form 'requestType="metadata"' \
      --form 'documentType="N"' \
      --form 'complementoCfdi="acreditamientoieps10"' \
      --form 'documentStatus="active"' \
      --form 'uuid="c4ee9b76-5c33-4c63-b63c-498cd956bd48"' \
      --form 'rfcOnBehalf="CUPU800825569"' \
      --form 'rfcMatches[]="CUPU800825569"' \
      --form 'rfcMatches[]="CUPU800825562"'
```
