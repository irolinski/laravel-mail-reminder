<?php

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/test-email-user', function() {
    try {
    Mail::mailer('user')->raw('This is a test email for Laravel using Gmail SMTP!', function($message){
        $message->to(env('ADMIN_MAIL_DESTINATION'))->subject('Test Email');
    });
    return 'Test email sent';
} catch (\Exception $e){
    Log::error('Mail sending failed: '.$e->getMessage());
    return 'Failed to send test email. Check logs for details';
}
});
Route::get('/test-email-admin', function() {
    try {
    Mail::mailer('admin')->raw('This is a test email for Laravel using Gmail SMTP!', function($message){
        $message->to(env('ADMIN_MAIL_DESTINATION'))->subject('Test Email');
    });
    return 'Test email sent';
} catch (\Exception $e){
    Log::error('Mail sending failed: '.$e->getMessage());
    return 'Failed to send test email. Check logs for details';
}
});