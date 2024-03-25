<?php

use App\Livewire\Tasks\TaskCreate;
use App\Livewire\Tasks\TaskIndex;
use App\Livewire\Tasks\TaskShow;
use App\Livewire\Tasks\TaskUpdate;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('tasks', TaskIndex::class)->name('tasks.index');
Route::get('tasks/create', TaskCreate::class);
Route::get('tasks/update', TaskUpdate::class);
Route::get('tasks/{task}', TaskShow::class);
