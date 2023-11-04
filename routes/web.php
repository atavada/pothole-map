    <?php

    use App\Http\Controllers\HomeController;
    use App\Http\Controllers\SaveDataController;
    use Illuminate\Support\Facades\Route;

    /*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

    Route::middleware(['web'])->group(function () {
        Route::get('/', function () {
            return view('home');
        });

        Route::get('/map', [HomeController::class, 'view'])->name('map');
        Route::post('/save-data', [SaveDataController::class, 'save'])->name('save');
        Route::get('/delete', [SaveDataController::class, 'delete'])->name('delete');
        Route::get('/pagerank', [HomeController::class, 'matrix'])->name('matrix');
        Route::get('/graph', [SaveDataController::class, 'store'])->name('store');
    });
