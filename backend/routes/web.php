<?php

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/test', function () {
    return 'Testing Testing Testing';
});


Route::get('/run-schedule', function() {
    abort_unless(request('token') === env('CRON_TOKEN'), 403);
    Artisan::call('schedule:run');
        return 'Scheduler executed!';

});