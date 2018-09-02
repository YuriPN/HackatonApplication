<?php

Route::get('/', function () {
    return view('welcome');
});
Route::get("/api", "Controlador@upload");
