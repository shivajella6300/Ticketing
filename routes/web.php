<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TicketController;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () 
{
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


// Admin routes group
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', function () 
    {
        return view('dashboard');
    })->name('admin.dashboard');
    //Ticketing List 
    Route::get('/getAlltickets', [TicketController::class,  "getAllTickets"])->name('admin.tickets');
    Route::post('/updateStatus', [TicketController::class,  "updateTicketStatus"])->name('update.ticketStatus');
    Route::get('/ticket-reponse',[TicketController::class, "TicketManyResponses"])->name('ticket.response');
});

// User routes group
Route::middleware(['auth', 'user'])->prefix('user')->group(function () 
{
    Route::get('/dashboard', function () 
    {
        return view('dashboard');
    })->name('user.dashboard');
    Route::get('/ticketForm',[TicketController::class, 'ticketForm'])->name('ticket.form');
    Route::get('/auth-tickets-list',[TicketController::class, "getAuthentTickets"])->name('user.ticketlist');
    Route::post('/raiseTickets',    [TicketController::class, "raiseTicket"])->name('ticket.raise');
    Route::get('/userHasManyTickets',[TicketController::class, "userHasManyTickets"])->name('user.hasManyTickets');
});


require __DIR__.'/auth.php';
