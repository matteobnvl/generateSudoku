<?php

use App\Route;

Route::get(['/', 'App\Controllers\SudokuController@index'])->name('sudoku');