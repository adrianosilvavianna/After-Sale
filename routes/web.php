<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/test-db-connection', function () {
//     try {
//         DB::connection()->getPdo();
//         echo "Conexão bem-sucedida!";
//     } catch (\Exception $e) {
//         die("Não foi possível conectar ao banco de dados: " . $e->getMessage());
//     }
// });