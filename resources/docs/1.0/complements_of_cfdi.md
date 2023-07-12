## cfdi-to-json

Este EndPoint Obtiene un listado de código y leyenda de los complementos de CFDI aceptados.

### **URL**

```textmate
    GET /api/v1/complements/cfdi
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
    "acreditamientoieps10": "Acreditamiento del IEPS 1.0",
    "aerolineas": "Aerolíneas 1.0",
    "cartaporte10": "Carta Porte 1.0",
    "cartaporte20": "Carta Porte 2.0",
    "certificadodedestruccion": "Certificado de destrucción 1.0",
    "cfdiregistrofiscal": "CFDI Registro fiscal 1.0",
    "comercioexterior10": "Comercio Exterior 1.0",
    "comercioexterior11": "Comercio Exterior 1.1",
    "consumodecombustibles": "Consumo de combustibles 1.0",
    "consumodecombustibles11": "Consumo de combustibles 1.1",
    "detallista": "Detallista",
    "divisas": "Divisas 1.0",
    "donat11": "Donatarias 1.1",
    "ecc11": "Estado de cuenta de combustibles 1.1",
    "ecc12": "Estado de cuenta de combustibles 1.2",
    "gastoshidrocarburos10": "Gastos Hidrocarburos 1.0",
    "iedu": "Instituciones educativas privadas 1.0",
    "implocal": "Impuestos locales 1.0",
    "ine11": "INE 1.1",
    "ingresoshidrocarburos": "Ingresos Hidrocarburos 1.0",
    "leyendasfisc": "Leyendas Fiscales 1.0",
    "nomina11": "Nómina 1.1",
    "nomina12": "Nómina 1.2",
    "notariospublicos": "Notarios públicos 1.0",
    "obrasarteantiguedades": "Obras de arte plásticas y antigüedades 1.0",
    "pagoenespecie": "Pago en especie 1.0",
    "pagos10": "Recepción de pagos 1.0",
    "pagos20": "Recepción de pagos 2.0",
    "pfic": "Persona física integrante de coordinado 1.0",
    "renovacionysustitucionvehiculos": "Renovación y sustitución de vehículos 1.0",
    "servicioparcialconstruccion": "Servicios parciales de construcción 1.0",
    "spei": "SPEI",
    "terceros11": "Terceros 1.1",
    "turistapasajeroextranjero": "Turista pasajero extranjero 1.0",
    "valesdedespensa": "Vales de despensa 1.0",
    "vehiculousado": "Vehículo usado 1.0",
    "ventavehiculos11": "Venta de vehículos 1.1"
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
curl --location --request GET 'http://127.0.0.1/api/v1/complements/cfdi' \
  --header 'Accept: application/json' \
  --header 'Authorization: Bearer 5|AzIdHDiVSJAaQ9tyL140jekVQroC6MqU8BPpVHgk'

```
