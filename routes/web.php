<?php

use App\Http\Controllers\ConfigurationController;
use App\Http\Controllers\PrintController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\TicketController;
use App\Http\Livewire\ScanerTickets;
use App\Models\Configuration;
use App\Models\Ticket;
use Illuminate\Support\Facades\Http;
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
    return view('auth.login');
});

Route::get('/reports',[ReportController::class, 'index'])->name('reports.index');
Route::get('/reports/{id}',[ReportController::class, 'show'])->name('reports.show');
Route::get('/configurations', [ConfigurationController::class, 'index'])->name('configurations');
Route::post('configurations/update/{id}', [ConfigurationController::class, 'update'])->name('configuration.update');
Route::get('/listprint',[ConfigurationController::class, 'getPrinter']);
Route::post('reprinter/{id}',[PrintController::class,'reprintTicket'])->name('printer.reprint');
Route::put('cancelticket/{id}',[TicketController::class,'cancel'])->name('ticket.cancel');

// Route::any('/testapi', function(){
//     $response = Http::post('https://pruebas-ecdd7-default-rtdb.firebaseio.com/.json', [
//         'name' => 'Steve',
//         'role' => 'Network Administrator',
//     ]);

//     return $response;
// });

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');
