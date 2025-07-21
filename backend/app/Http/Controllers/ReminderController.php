<?php

namespace App\Http\Controllers;

use App\Models\Reminder;
use Illuminate\Http\Request;

class ReminderController extends Controller
{
    public function store(Request $request) {
        $validated = $request->validate([
            'email'=>'required|email',
            'subject' => 'nullable|string|max:200',
            'message'=>'nullable|string|max:300',
            'send_at'=>'required|date|after:now',
        ]);
        
        $reminder = Reminder::create($validated);

        return response()->json([
            'message' => 'Reminder scheduled!',
            'reminder' => $reminder,
        ], 201);
    }
}