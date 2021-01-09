<?php

use App\Http\Controllers\Admin\SubstancesController;
use App\Http\Livewire\Admin\DrugsControl;
use App\Http\Livewire\MainPage;
use App\Http\Livewire\Admin\SubstancesControl;
use App\Http\Livewire\SearchPage;
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

Route::get('/', MainPage::class)->name('main-page');

Route::get('/substance', SubstancesControl::class)->name('substances-control');

Route::get('/drugs', DrugsControl::class)->name('drugs-control');

Route::get('/search', SearchPage::class)->name('search-page');

