<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reminder extends Model
{
    protected $fillable = ['email', 'subject', 'message', 'send_at', 'sent'];
}
