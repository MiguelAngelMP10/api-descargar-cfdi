## Complements of retention

Este EndPoint Obtiene un listado de código y leyenda de los complementos de CFDI de Retenciones aceptados.

### **URL**

```textmate
    GET /api/v1/complements/retention
```

### Headers

`Authorization: Bearer {token}`

`Accept: application/json`

### **URL Params**

```text
    None
```

### **Data Params**

```text
    None
```

> {success} Success Response Aceptada

**Code:** `200`

**Content:**

```json
{
  "data": {
    "": "Sin complemento definido",
    "arrendamientoenfideicomiso": "Arrendamiento en fideicomiso",
    "dividendos": "Dividendos",
    "enajenaciondeacciones": "Enajenación de acciones",
    "fideicomisonoempresarial": "Fideicomiso no empresarial",
    "intereses": "Intereses",
    "intereseshipotecarios": "Intereses hipotecarios",
    "operacionesconderivados": "Operaciones con derivados",
    "pagosaextranjeros": "Pagos a extranjeros",
    "planesderetiro": "Planes de retiro 1.0",
    "planesderetiro11": "Planes de retiro 1.1",
    "premios": "Premios",
    "sectorfinanciero": "Sector Financiero",
    "serviciosplataformastecnologicas10": "Servicios Plataformas Tecnológicas"
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
curl --location --request GET 'http://127.0.0.1/api/v1/complements/retention' \
  --header 'Accept: application/json' \
  --header 'Authorization: Bearer 5|AzIdHDiVSJAaQ9tyL140jekVQroC6MqU8BPpVHgk'
```
