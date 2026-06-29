<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SystemLog extends Model
{
    protected $fillable = ['level', 'message', 'action', 'context'];

    const UPDATED_AT = null;
    const CREATED_AT = 'created_at';
}
