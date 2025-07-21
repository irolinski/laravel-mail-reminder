<?php

namespace App\Jobs;

use App\Models\Reminder;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendDueReminders implements ShouldQueue
{
    use Queueable, InteractsWithQueue, SerializesModels;

    public function handle(): void
    {
        $dueReminders = Reminder::where('sent', false)
        ->where('send_at', '<=', now())
        ->get();

        foreach ($dueReminders as $reminder) {
            try {
                Mail::mailer('user')->raw($reminder->message ?? "This is a reminder message sent by mailReminder." , function($message) use ($reminder){
                    $message->to($reminder->email)
                    ->subject($reminder->sunject ?? "Reminder");
                });

                $reminder->sent = true;
                $reminder->save();
                Log::info("Successfully sent a reminder of num {$reminder->id}.");
            } catch (\Exception $e){
                Log::error("Failed to send reminder #{$reminder->id} to {$reminder->email}: ".$e->getMessage());
            }
        }
    }

    public function failed(\Throwable $exception)
    {
        Log::error("SendDueReminders job failed: ".$exception->getMessage());
        Mail::mailer('admin')->raw("SendDueReminders job failed with error: ".$exception->getMessage(), function($message){
            $message->to(env('ADMIN_MAIL_DESTINATION'))->subject('SendDueReminders Job Failed');
        });
    }
}
