<?php

use App\Http\Controllers\api\Catalogs\CceClavesPedimentosController;
use App\Http\Controllers\api\Catalogs\CceColoniasController;
use App\Http\Controllers\api\Catalogs\CceEstadosController;
use App\Http\Controllers\api\Catalogs\CceFraccionesArancelariasController;
use App\Http\Controllers\api\Catalogs\CceIncotermsController;
use App\Http\Controllers\api\Catalogs\CceLocalidadesController;
use App\Http\Controllers\api\Catalogs\CceMotivosTrasladoController;
use App\Http\Controllers\api\Catalogs\CceMunicipiosController;
use App\Http\Controllers\api\Catalogs\CceTiposOperacionController;
use App\Http\Controllers\api\Catalogs\CceUnidadesMedidaController;
use App\Http\Controllers\api\Catalogs\Ccp20AutorizacionesNavieroController;
use App\Http\Controllers\api\Catalogs\Ccp20ClavesUnidadesController;
use App\Http\Controllers\api\Catalogs\Ccp20CodigosTransporteAereoController;
use App\Http\Controllers\api\Catalogs\Ccp20ColoniasController;
use App\Http\Controllers\api\Catalogs\Ccp20ConfiguracionesAutotransporteController;
use App\Http\Controllers\api\Catalogs\Ccp20ConfiguracionesMaritimasController;
use App\Http\Controllers\api\Catalogs\Ccp20ContenedoresController;
use App\Http\Controllers\api\Catalogs\Ccp20ContenedoresMaritimosController;
use App\Http\Controllers\api\Catalogs\Ccp20DerechosDePasoController;
use App\Http\Controllers\api\Catalogs\Ccp20EstacionesController;
use App\Http\Controllers\api\Catalogs\Ccp20FigurasTransporteController;
use App\Http\Controllers\api\Catalogs\Ccp20LocalidadesController;
use App\Http\Controllers\api\Catalogs\Ccp20MaterialesPeligrososController;
use App\Http\Controllers\api\Catalogs\Ccp20MunicipiosController;
use App\Http\Controllers\api\Catalogs\Ccp20PartesTransporteController;
use App\Http\Controllers\api\Catalogs\Ccp20ProductosServiciosController;
use App\Http\Controllers\api\Catalogs\Ccp20TiposCargaController;
use App\Http\Controllers\api\Catalogs\Ccp20TiposCarroController;
use App\Http\Controllers\api\Catalogs\Ccp20TiposEmbalajeController;
use App\Http\Controllers\api\Catalogs\Ccp20TiposEstacionController;
use App\Http\Controllers\api\Catalogs\Ccp20TiposPermisoController;
use App\Http\Controllers\api\Catalogs\Ccp20TiposRemolqueController;
use App\Http\Controllers\api\Catalogs\Ccp20TiposServicioController;
use App\Http\Controllers\api\Catalogs\Ccp20TiposTraficoController;
use App\Http\Controllers\api\Catalogs\Ccp20TransportesController;
use App\Http\Controllers\api\Catalogs\Cfdi40AduanasController;
use App\Http\Controllers\api\Catalogs\Cfdi40ClavesUnidadesController;
use App\Http\Controllers\api\Catalogs\Cfdi40CodigosPostalesController;
use App\Http\Controllers\api\Catalogs\Cfdi40ColoniasController;
use App\Http\Controllers\api\Catalogs\Cfdi40EstadosController;
use App\Http\Controllers\api\Catalogs\Cfdi40ExportacionesController;
use App\Http\Controllers\api\Catalogs\Cfdi40FormasPagoController;
use App\Http\Controllers\api\Catalogs\Cfdi40ImpuestosController;
use App\Http\Controllers\api\Catalogs\Cfdi40LocalidadesController;
use App\Http\Controllers\api\Catalogs\Cfdi40MesesController;
use App\Http\Controllers\api\Catalogs\Cfdi40MetodosPagoController;
use App\Http\Controllers\api\Catalogs\Cfdi40MonedasController;
use App\Http\Controllers\api\Catalogs\Cfdi40MunicipiosController;
use App\Http\Controllers\api\Catalogs\Cfdi40NumerosPedimentoAduanaController;
use App\Http\Controllers\api\Catalogs\Cfdi40ObjetosImpuestosController;
use App\Http\Controllers\api\Catalogs\Cfdi40PaisesController;
use App\Http\Controllers\api\Catalogs\Cfdi40PatentesAduanalesController;
use App\Http\Controllers\api\Catalogs\Cfdi40PeriodicidadesController;
use App\Http\Controllers\api\Catalogs\Cfdi40ProductosServiciosController;
use App\Http\Controllers\api\Catalogs\Cfdi40RegimenesFiscalesController;
use App\Http\Controllers\api\Catalogs\Cfdi40ReglasTasaCuotaController;
use App\Http\Controllers\api\Catalogs\Cfdi40TiposComprobantesController;
use App\Http\Controllers\api\Catalogs\Cfdi40TiposFactoresController;
use App\Http\Controllers\api\Catalogs\Cfdi40TiposRelacionesController;
use App\Http\Controllers\api\Catalogs\Cfdi40UsosCfdiController;
use App\Http\Controllers\api\Catalogs\CfdiAduanasController;
use App\Http\Controllers\api\Catalogs\CfdiClavesUnidadesController;
use App\Http\Controllers\api\Catalogs\CfdiCodigosPostalesController;
use App\Http\Controllers\api\Catalogs\CfdiFormasPagoController;
use App\Http\Controllers\api\Catalogs\CfdiImpuestosController;
use App\Http\Controllers\api\Catalogs\CfdiMetodosPagoController;
use App\Http\Controllers\api\Catalogs\CfdiMonedasController;
use App\Http\Controllers\api\Catalogs\CfdiNumerosPedimentoAduanaController;
use App\Http\Controllers\api\Catalogs\CfdiPaisesController;
use App\Http\Controllers\api\Catalogs\CfdiPatentesAduanalesController;
use App\Http\Controllers\api\Catalogs\CfdiProductosServiciosController;
use App\Http\Controllers\api\Catalogs\CfdiRegimenesFiscalesController;
use App\Http\Controllers\api\Catalogs\CfdiReglasTasaCuotaController;
use App\Http\Controllers\api\Catalogs\CfdiTiposComprobantesController;
use App\Http\Controllers\api\Catalogs\CfdiTiposFactoresController;
use App\Http\Controllers\api\Catalogs\CfdiTiposRelacionesController;
use App\Http\Controllers\api\Catalogs\CfdiUsosCfdiController;
use App\Http\Controllers\api\Catalogs\NominaBancosController;
use App\Http\Controllers\api\Catalogs\NominaEstadosController;
use App\Http\Controllers\api\Catalogs\NominaOrigenesRecursosController;
use App\Http\Controllers\api\Catalogs\NominaPeriodicidadesPagosController;
use App\Http\Controllers\api\Catalogs\NominaRiesgosPuestosController;
use App\Http\Controllers\api\Catalogs\NominaTiposContratosController;
use App\Http\Controllers\api\Catalogs\NominaTiposDeduccionesController;
use App\Http\Controllers\api\Catalogs\NominaTiposHorasController;
use App\Http\Controllers\api\Catalogs\NominaTiposIncapacidadesController;
use App\Http\Controllers\api\Catalogs\NominaTiposJornadasController;
use App\Http\Controllers\api\Catalogs\NominaTiposNominasController;
use App\Http\Controllers\api\Catalogs\NominaTiposOtrosPagosController;
use App\Http\Controllers\api\Catalogs\NominaTiposPercepcionesController;
use App\Http\Controllers\api\Catalogs\NominaTiposRegimenesController;
use App\Http\Controllers\api\Catalogs\PagosTiposCadenaPagoController;
use App\Http\Controllers\api\Catalogs\Ret20ClavesRetencionController;
use App\Http\Controllers\api\Catalogs\Ret20EjerciciosController;
use App\Http\Controllers\api\Catalogs\Ret20EntidadesFederativasController;
use App\Http\Controllers\api\Catalogs\Ret20PaisesController;
use App\Http\Controllers\api\Catalogs\Ret20PeriodicidadesController;
use App\Http\Controllers\api\Catalogs\Ret20PeriodosController;
use App\Http\Controllers\api\Catalogs\Ret20TiposContribuyentesController;
use App\Http\Controllers\api\Catalogs\Ret20TiposDividendosUtilidadesController;
use App\Http\Controllers\api\Catalogs\Ret20TiposImpuestosController;
use App\Http\Controllers\api\Catalogs\Ret20TiposPagoRetencionController;
use Illuminate\Support\Facades\Route;
use Orion\Facades\Orion;

Route::prefix('v1/catalogs')
    ->middleware('auth:sanctum')
    ->group(function () {
        Orion::resource('cce-claves-pedimentos', CceClavesPedimentosController::class)
            ->only(['index', 'search', 'show']);
        Orion::resource('cce-colonias', CceColoniasController::class)
            ->only(['index', 'search']);
        Orion::resource('cce-estados', CceEstadosController::class)
            ->only(['index', 'search']);
        Orion::resource('cce-fracciones-arancelarias', CceFraccionesArancelariasController::class)
            ->only(['index', 'search', 'show']);
        Orion::resource('cce-incoterms', CceIncotermsController::class)
            ->only(['index', 'search', 'show']);
        Orion::resource('cce-localidades', CceLocalidadesController::class)
            ->only(['index', 'search']);
        Orion::resource('cce-motivos-traslado', CceMotivosTrasladoController::class)
            ->only(['index', 'search', 'show']);
        Orion::resource('cce-municipios', CceMunicipiosController::class)
            ->only(['index', 'search']);
        Orion::resource('cce-tipos-operacion', CceTiposOperacionController::class)
            ->only(['index', 'search', 'show']);
        Orion::resource('cce-unidades-medida', CceUnidadesMedidaController::class)
            ->only(['index', 'search', 'show']);
        Orion::resource('ccp-20-autorizaciones-naviero', Ccp20AutorizacionesNavieroController::class)
            ->only(['index', 'search', 'show']);
        Orion::resource('ccp-20-claves-unidades', Ccp20ClavesUnidadesController::class)
            ->only(['index', 'search', 'show']);
        Orion::resource('ccp-20-codigos-transporte-aereo', Ccp20CodigosTransporteAereoController::class)
            ->only(['index', 'search', 'show']);
        Orion::resource('ccp-20-colonias', Ccp20ColoniasController::class)
            ->only(['index', 'search']);
        Orion::resource('ccp-20-configuraciones-autotrans', Ccp20ConfiguracionesAutotransporteController::class)
            ->only(['index', 'search', 'show']);
        Orion::resource('ccp-20-configuraciones-maritimas', Ccp20ConfiguracionesMaritimasController::class)
            ->only(['index', 'search', 'show']);
        Orion::resource('ccp-20-contenedores', Ccp20ContenedoresController::class)
            ->only(['index', 'search', 'show']);
        Orion::resource('ccp-20-contenedores-maritimos', Ccp20ContenedoresMaritimosController::class)
            ->only(['index', 'search', 'show']);
        Orion::resource('ccp-20-derechos-de-paso', Ccp20DerechosDePasoController::class)
            ->only(['index', 'search', 'show']);
        Orion::resource('ccp-20-estaciones', Ccp20EstacionesController::class)
            ->only(['index', 'search', 'show']);
        Orion::resource('ccp-20-figuras-transporte', Ccp20FigurasTransporteController::class)
            ->only(['index', 'search', 'show']);
        Orion::resource('ccp-20-localidades', Ccp20LocalidadesController::class)
            ->only(['index', 'search']);
        Orion::resource('ccp-20-materiales-peligrosos', Ccp20MaterialesPeligrososController::class)
            ->only(['index', 'search', 'show']);
        Orion::resource('ccp-20-municipios', Ccp20MunicipiosController::class)
            ->only(['index', 'search']);
        Orion::resource('ccp-20-partes-transporte', Ccp20PartesTransporteController::class)
            ->only(['index', 'search', 'show']);
        Orion::resource('ccp-20-productos-servicios', Ccp20ProductosServiciosController::class)
            ->only(['index', 'search', 'show']);
        Orion::resource('ccp-20-tipos-carga', Ccp20TiposCargaController::class)
            ->only(['index', 'search', 'show']);
        Orion::resource('ccp-20-tipos-carro', Ccp20TiposCarroController::class)
            ->only(['index', 'search', 'show']);
        Orion::resource('ccp-20-tipos-embalaje', Ccp20TiposEmbalajeController::class)
            ->only(['index', 'search', 'show']);
        Orion::resource('ccp-20-tipos-estacion', Ccp20TiposEstacionController::class)
            ->only(['index', 'search', 'show']);
        Orion::resource('ccp-20-tipos-permiso', Ccp20TiposPermisoController::class)
            ->only(['index', 'search', 'show']);
        Orion::resource('ccp-20-tipos-remolque', Ccp20TiposRemolqueController::class)
            ->only(['index', 'search', 'show']);
        Orion::resource('ccp-20-tipos-servicio', Ccp20TiposServicioController::class)
            ->only(['index', 'search', 'show']);
        Orion::resource('ccp-20-tipos-trafico', Ccp20TiposTraficoController::class)
            ->only(['index', 'search', 'show']);
        Orion::resource('ccp-20-transportes', Ccp20TransportesController::class)
            ->only(['index', 'search', 'show']);
        Orion::resource('cfdi-40-aduanas', Cfdi40AduanasController::class)
            ->only(['index', 'search', 'show']);
        Orion::resource('cfdi-40-claves-unidades', Cfdi40ClavesUnidadesController::class)
            ->only(['index', 'search', 'show']);
        Orion::resource('cfdi-40-codigos-postales', Cfdi40CodigosPostalesController::class)
            ->only(['index', 'search', 'show']);
        Orion::resource('cfdi-40-colonias', Cfdi40ColoniasController::class)
            ->only(['index', 'search']);
        Orion::resource('cfdi-40-estados', Cfdi40EstadosController::class)
            ->only(['index', 'search']);
        Orion::resource('cfdi-40-exportaciones', Cfdi40ExportacionesController::class)
            ->only(['index', 'search', 'show']);
        Orion::resource('cfdi-40-formas-pago', Cfdi40FormasPagoController::class)
            ->only(['index', 'search', 'show']);
        Orion::resource('cfdi-40-impuestos', Cfdi40ImpuestosController::class)
            ->only(['index', 'search', 'show']);
        Orion::resource('cfdi-40-localidades', Cfdi40LocalidadesController::class)
            ->only(['index', 'search']);
        Orion::resource('cfdi-40-meses', Cfdi40MesesController::class)
            ->only(['index', 'search', 'show']);
        Orion::resource('cfdi-40-metodos-pago', Cfdi40MetodosPagoController::class)
            ->only(['index', 'search', 'show']);
        Orion::resource('cfdi-40-monedas', Cfdi40MonedasController::class)
            ->only(['index', 'search', 'show']);
        Orion::resource('cfdi-40-municipios', Cfdi40MunicipiosController::class)
            ->only(['index', 'search']);
        Orion::resource('cfdi-40-numeros-pedimento-aduana', Cfdi40NumerosPedimentoAduanaController::class)
            ->only(['index', 'search', 'show']);
        Orion::resource('cfdi-40-objetos-impuestos', Cfdi40ObjetosImpuestosController::class)
            ->only(['index', 'search', 'show']);
        Orion::resource('cfdi-40-paises', Cfdi40PaisesController::class)
            ->only(['index', 'search', 'show']);
        Orion::resource('cfdi-40-patentes-aduanales', Cfdi40PatentesAduanalesController::class)
            ->only(['index', 'search', 'show']);
        Orion::resource('cfdi-40-periodicidades', Cfdi40PeriodicidadesController::class)
            ->only(['index', 'search', 'show']);
        Orion::resource('cfdi-40-productos-servicios', Cfdi40ProductosServiciosController::class)
            ->only(['index', 'search', 'show']);
        Orion::resource('cfdi-40-regimenes-fiscales', Cfdi40RegimenesFiscalesController::class)
            ->only(['index', 'search', 'show']);
        Orion::resource('cfdi-40-reglas-tasa-cuota', Cfdi40ReglasTasaCuotaController::class)
            ->only(['index', 'search', 'show']);
        Orion::resource('cfdi-40-tipos-comprobantes', Cfdi40TiposComprobantesController::class)
            ->only(['index', 'search', 'show']);
        Orion::resource('cfdi-40-tipos-factores', Cfdi40TiposFactoresController::class)
            ->only(['index', 'search', 'show']);
        Orion::resource('cfdi-40-tipos-relaciones', Cfdi40TiposRelacionesController::class)
            ->only(['index', 'search', 'show']);
        Orion::resource('cfdi-40-usos-cfdi', Cfdi40UsosCfdiController::class)
            ->only(['index', 'search', 'show']);
        Orion::resource('cfdi-aduanas', CfdiAduanasController::class)
            ->only(['index', 'search', 'show']);
        Orion::resource('cfdi-claves-unidades', CfdiClavesUnidadesController::class)
            ->only(['index', 'search', 'show']);
        Orion::resource('cfdi-codigos-postales', CfdiCodigosPostalesController::class)
            ->only(['index', 'search', 'show']);
        Orion::resource('cfdi-formas-pago', CfdiFormasPagoController::class)
            ->only(['index', 'search', 'show']);
        Orion::resource('cfdi-impuestos', CfdiImpuestosController::class)
            ->only(['index', 'search', 'show']);
        Orion::resource('cfdi-metodos-pago', CfdiMetodosPagoController::class)
            ->only(['index', 'search', 'show']);
        Orion::resource('cfdi-monedas', CfdiMonedasController::class)
            ->only(['index', 'search', 'show']);
        Orion::resource('cfdi-numeros-pedimento-aduana', CfdiNumerosPedimentoAduanaController::class)
            ->only(['index', 'search', 'show']);
        Orion::resource('cfdi-paises', CfdiPaisesController::class)
            ->only(['index', 'search', 'show']);
        Orion::resource('cfdi-patentes-aduanales', CfdiPatentesAduanalesController::class)
            ->only(['index', 'search', 'show']);
        Orion::resource('cfdi-productos-servicios', CfdiProductosServiciosController::class)
            ->only(['index', 'search', 'show']);
        Orion::resource('cfdi-regimenes-fiscales', CfdiRegimenesFiscalesController::class)
            ->only(['index', 'search', 'show']);
        Orion::resource('cfdi-reglas-tasa-cuota', CfdiReglasTasaCuotaController::class)
            ->only(['index', 'search', 'show']);
        Orion::resource('cfdi-tipos-comprobantes', CfdiTiposComprobantesController::class)
            ->only(['index', 'search', 'show']);
        Orion::resource('cfdi-tipos-factores', CfdiTiposFactoresController::class)
            ->only(['index', 'search', 'show']);
        Orion::resource('cfdi-tipos-relaciones', CfdiTiposRelacionesController::class)
            ->only(['index', 'search', 'show']);
        Orion::resource('cfdi-usos-cfdi', CfdiUsosCfdiController::class)
            ->only(['index', 'search', 'show']);
        Orion::resource('nomina-bancos', NominaBancosController::class)
            ->only(['index', 'search', 'show']);
        Orion::resource('nomina-estados', NominaEstadosController::class)
            ->only(['index', 'search']);
        Orion::resource('nomina-origenes-recursos', NominaOrigenesRecursosController::class)
            ->only(['index', 'search', 'show']);
        Orion::resource('nomina-periodicidades-pagos', NominaPeriodicidadesPagosController::class)
            ->only(['index', 'search', 'show']);
        Orion::resource('nomina-riesgos-puestos', NominaRiesgosPuestosController::class)
            ->only(['index', 'search', 'show']);
        Orion::resource('nomina-tipos-contratos', NominaTiposContratosController::class)
            ->only(['index', 'search', 'show']);
        Orion::resource('nomina-tipos-deducciones', NominaTiposDeduccionesController::class)
            ->only(['index', 'search', 'show']);
        Orion::resource('nomina-tipos-horas', NominaTiposHorasController::class)
            ->only(['index', 'search', 'show']);
        Orion::resource('nomina-tipos-incapacidades', NominaTiposIncapacidadesController::class)
            ->only(['index', 'search', 'show']);
        Orion::resource('nomina-tipos-jornadas', NominaTiposJornadasController::class)
            ->only(['index', 'search', 'show']);
        Orion::resource('nomina-tipos-nominas', NominaTiposNominasController::class)
            ->only(['index', 'search', 'show']);
        Orion::resource('nomina-tipos-otros-pagos', NominaTiposOtrosPagosController::class)
            ->only(['index', 'search', 'show']);
        Orion::resource('nomina-tipos-percepciones', NominaTiposPercepcionesController::class)
            ->only(['index', 'search', 'show']);
        Orion::resource('nomina-tipos-regimenes', NominaTiposRegimenesController::class)
            ->only(['index', 'search', 'show']);
        Orion::resource('pagos-tipos-cadena-pago', PagosTiposCadenaPagoController::class)
            ->only(['index', 'search', 'show']);
        Orion::resource('ret-20-claves-retencion', Ret20ClavesRetencionController::class)
            ->only(['index', 'search', 'show']);
        Orion::resource('ret-20-ejercicios', Ret20EjerciciosController::class)
            ->only(['index', 'search', 'show']);
        Orion::resource('ret-20-entidades-federativas', Ret20EntidadesFederativasController::class)
            ->only(['index', 'search', 'show']);
        Orion::resource('ret-20-paises', Ret20PaisesController::class)
            ->only(['index', 'search', 'show']);
        Orion::resource('ret-20-periodicidades', Ret20PeriodicidadesController::class)
            ->only(['index', 'search', 'show']);
        Orion::resource('ret-20-periodos', Ret20PeriodosController::class)
            ->only(['index', 'search', 'show']);
        Orion::resource('ret-20-tipos-contribuyentes', Ret20TiposContribuyentesController::class)
            ->only(['index', 'search', 'show']);
        Orion::resource('ret-20-tipos-dividendos-utilidad', Ret20TiposDividendosUtilidadesController::class)
            ->only(['index', 'search', 'show']);
        Orion::resource('ret-20-tipos-impuestos', Ret20TiposImpuestosController::class)
            ->only(['index', 'search', 'show']);
        Orion::resource('ret-20-tipos-pago-retencion', Ret20TiposPagoRetencionController::class)
            ->only(['index', 'search', 'show']);
    });
