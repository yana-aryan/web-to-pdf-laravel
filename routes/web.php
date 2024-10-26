<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PDFController;
Route::get("/",function(){
    return view("welcome");
});
Route::controller(PDFController::class)->group(function(){
    Route::post("/generatePDF","generatePDF")->name("generate_pdf");
});

Route::fallback(function(){
    return "<h1>No page found</h1>";
});
