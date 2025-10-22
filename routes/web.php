<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RedirectController;
use App\Http\Controllers\CentroUniversitarioController;
use App\Http\Controllers\CoordinadoresController;
use App\Http\Controllers\PosgradosController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DatosGeneralesController;
use App\Http\Controllers\SolicitudController;
use App\Http\Controllers\RubroCategoriaController;
use App\Http\Controllers\RubroController;
use App\Http\Controllers\RubroSolicitadosController;
use App\Http\Controllers\OtroRubroController;
use App\Http\Controllers\DocumentacionController;
use App\Http\Controllers\Catalogos\CascadaController;
use App\Http\Controllers\InformeController;
use App\Http\Controllers\ConvocatoriaController;
use App\Http\Controllers\SolicitudAdminController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Página de inicio
Route::get('/', function () {
    return view('welcome');
});

// Dashboard dinámico (redirige según rol)
Route::get('/dashboard', RedirectController::class)->middleware(['auth', 'verified'])->name('dashboard');

// Ruta del aviso de privacidad (pública)
Route::view('/aviso-de-privacidad', 'legal.privacy')->name('privacy.notice');

// Perfil de usuario (editar, actualizar, eliminar)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

    // USUARIO (ROL 1)
    Route::middleware(['auth', 'role:1', 'verified'])->prefix('usuario')->as('usuario.')->group(function () {

    // DASHABOARD
    Route::get('/', fn () => view('usuario.dashboard'))->name('dashboard');
  
    // DATOS GENERALES
    Route::get('/datos-generales', [DatosGeneralesController::class, 'create'])->name('datos-generales.create');
    Route::post('/datos-generales', [DatosGeneralesController::class, 'store'])->name('datos-generales.store');
    Route::get('/datos-generales/{id}/editar', [DatosGeneralesController::class, 'edit'])->name('datos-generales.edit');
    Route::put('/datos-generales/{id}', [DatosGeneralesController::class, 'update'])->name('datos-generales.update');

    // SOLICITUDES
    Route::resource('solicitud', SolicitudController::class)->names('solicitud');
    
    // SOLICITUD PDF
    Route::get('/oficios/solicitud/pdf', [SolicitudController::class, 'pdfActual'])->name('oficios.solicitud.pdf');
    Route::get('/oficios/solicitud/{id}/pdf', [SolicitudController::class, 'generarPDF'])->name('oficios.solicitud.id.pdf');
 

    // RUBROS SOLICITADOS
    Route::prefix('rubros-solicitados')->name('rubros-solicitados.')->group(function () {
    // Vistas principales
    Route::get('/create',        [RubroSolicitadosController::class, 'create'])->name('create');
    Route::get('/{id}/edit',     [RubroSolicitadosController::class, 'edit'])->name('edit');

    // Guardado por sección
    Route::post('/rubros/save/{user}', [RubroSolicitadosController::class, 'saveRubros'])->name('rubros.save');
    Route::post('/otros/save/{user}',  [RubroSolicitadosController::class, 'saveOtros'])->name('otros.save');
    });
    
    // Rutas REST necesarias para formularios (PUT/PATCH/DELETE)
    // Genera: usuario.rubros-solicitados.store / update / destroy
    Route::resource('rubros-solicitados', RubroSolicitadosController::class)->only(['store','update','destroy'])->names('rubros-solicitados');

    // OTROS RUBROS (CRUD completo)
    Route::resource('otros-rubros', OtroRubroController::class)->names('otros-rubros');

    // DOCUMENTACIONES
    Route::get('/documentaciones/create', [DocumentacionController::class, 'create'])->name('documentaciones.create');
    Route::post('/documentaciones', [DocumentacionController::class, 'store'])->name('documentaciones.store');
    Route::put('/documentaciones/{campo}', [DocumentacionController::class, 'update'])->name('documentaciones.update');
    Route::delete('/documentaciones/{field}', [DocumentacionController::class, 'destroyFile'])->name('documentaciones.deleteFile');

    // INFORME
    Route::resource('informes', InformeController::class);
    //Route::get('/informes/categorias/{categoria}/criterios', [InformeController::class, 'criteriosPorCategoria'])->name('informes.categorias.criterios');
    //Route::resource('usuario/informes', InformeController::class)->names('usuario.informes');  // 👈 Esto asegura names como usuario.informes.index
    Route::get('informes/categorias/{categoria}/criterios', [InformeController::class, 'criteriosPorCategoria'])->name('informes.categorias.criterios');
    
});

// Coordinador (rol 2)
Route::middleware(['auth', 'role:2'])->group(function () {
    Route::get('/coordinador', fn () => view('coordinador.dashboard'))->name('coordinador.dashboard');
});

    // ADMINISTRADOR (ROL 3)
    Route::middleware(['auth', 'role:3', 'verified'])->prefix('admin')->as('admin.')->group(function () {

                Route::get('/', function () {

            // Tablas (ajusta si tus prefijos son otros)
            $posgradosTable = Schema::hasTable('pfp_posgrados') ? 'pfp_posgrados' : (Schema::hasTable('posgrados') ? 'posgrados' : null);
            $centrosTable   = Schema::hasTable('pfp_centros')   ? 'pfp_centros'   : (Schema::hasTable('centros')   ? 'centros'   : null);

            $chartLabels = collect();
            $chartData   = collect();
            $hasData     = false;

            if ($posgradosTable) {
                // Intentos de FK numérica habituales
                $fkCandidates = ['centro_id', 'centro_universitario_id', 'id_centro', 'id_centro_universitario'];
                $fk = collect($fkCandidates)->first(fn($c) => Schema::hasColumn($posgradosTable, $c));

                if ($fk && $centrosTable && Schema::hasColumn($centrosTable, 'id') && Schema::hasColumn($centrosTable, 'centro_universitario')) {
                    // JOIN por FK
                    $stats = DB::table("$posgradosTable as p")
                        ->join("$centrosTable as c", "c.id", "=", "p.$fk")
                        ->select('c.centro_universitario as label', DB::raw('COUNT(*) as total'))
                        ->groupBy('c.centro_universitario')
                        ->orderByDesc('total')
                        ->get();

                    $chartLabels = $stats->pluck('label');
                    $chartData   = $stats->pluck('total');
                    $hasData     = $chartData->sum() > 0;
                } else {
                    // Buscar columna de texto que contenga el nombre del centro en la propia tabla de posgrados
                    $textCandidates = ['centro_universitario', 'centro', 'siglas', 'nombre_centro'];
                    $txt = collect($textCandidates)->first(fn($c) => Schema::hasColumn($posgradosTable, $c));

                    if ($txt) {
                        $stats = DB::table($posgradosTable)
                            ->select("$txt as label", DB::raw('COUNT(*) as total'))
                            ->groupBy($txt)
                            ->orderByDesc('total')
                            ->get();

                        $chartLabels = $stats->pluck('label');
                        $chartData   = $stats->pluck('total');
                        $hasData     = $chartData->sum() > 0;
                    }
                }
            }

            return view('administrador.dashboard', compact('chartLabels', 'chartData', 'hasData'));
        })->name('dashboard');



        // CSV CENTROS UNIVERSITARIOS
        Route::prefix('centros')->name('centros.')->group(function () {
        Route::get('plantilla', [CentroUniversitarioController::class, 'plantillaCsv'])->name('plantilla');
        Route::post('import',   [CentroUniversitarioController::class, 'importCsv'])->name('import');
        });

        // CRUD CENTROS UNIVERSITARIOS
        Route::resource('centros', CentroUniversitarioController::class)->parameters(['centros' => 'centro']);

        // CSV POSGRADOS
        Route::prefix('posgrados')->name('posgrados.')->group(function () {
        Route::get('plantilla', [PosgradosController::class, 'plantillaCsv'])->name('plantilla');
        Route::post('import',   [PosgradosController::class, 'importCsv'])->name('import');
        });

        // CRUD POSGRADOS
        Route::resource('posgrados', PosgradosController::class)->parameters(['posgrados' => 'posgrado']); // {posgrado} para route-model binding


        // CRUD Coordinadores -> admin.coordinadores.index/create/store/show/edit/update/destroy
        Route::resource('coordinadores', CoordinadoresController::class)->parameters(['coordinadores' => 'coordinador']);

        // CRUD USUARIOS -> admin.usuarios.index/create/store/show/edit/update/destroy
        Route::resource('usuarios', UserController::class)->parameters(['usuarios' => 'usuario']); // {usuarios} para route-model binding

        // CRUD RUBROSCATEGORIAS (vista: resources/views/admin/rubros-categorias/*)
        Route::resource('rubros-categorias', RubroCategoriaController::class)->parameters(['rubros-categorias' => 'categoria']); // <-- clave

        // CRUD RUBROS (vista: resources/views/admin/rubros/*)
        Route::resource('rubros', RubroController::class)->names('rubros');

        // CRUD CONVOCATORIAS (vista: resources/views/admin/Convocatorias/*)
        Route::resource('convocatorias', ConvocatoriaController::class);

        // SOLICITUDES REGISTRADAS
        Route::get('/solicitudes', [SolicitudAdminController::class, 'index'])->name('solicitudes.index');
        Route::get('/solicitudes/{id}', [SolicitudAdminController::class, 'show'])->whereNumber('id')->name('solicitudes.show');
        Route::get('/solicitudes/{id}/pdf', [SolicitudAdminController::class, 'pdf'])->whereNumber('id')->name('solicitudes.pdf');
        
    });

// Autenticación (Breeze/Jetstream)
require __DIR__ . '/auth.php';