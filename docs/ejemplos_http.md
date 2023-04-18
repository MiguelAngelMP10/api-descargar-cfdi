# Ejemplos de uso via http

## En los siguientes enlaces se encuentan ejemplos de cada uno de los endpoints.

* [Send cer and key](ExampleSendCerKey.md)

* [Make query](../resources/docs/1.0/ExampleMakeQuery.md)

* [Verify Query](../resources/docs/1.0/ExampleVerifyQuery.md)

* [Download Packages](../resources/docs/1.0/ExampleDownloadPackages.md)

* [Packages](../resources/docs/1.0/ExamplePackages.md)

- Lista de endPoints
  ```text
   - POST /api/v1/send-cer-key
   - POST /api/v1/make-query
   - POST /api/v1/verify-query
   - POST /api/v1/download-packages
   - GET /api/v1/{rfc}/packages
   - GET /api/v1/{rfc}/packages/{packageId}
   - DELETE /api/v1/{rfc}/packages/{packageId}
  ```

Los endpoints antes mencionados requieren autenticación (bearer token), por lo que en los requests debera agregar un
header `Authorization: Bearer {token}`
