<?php

namespace App\Models;

use App\Models\Category;
use App\Models\ComplaintLog;
use App\Models\ComplaintPhoto;
use App\Models\Location;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
    protected $fillable = [
        'kode_barang',
        'user_id',
        'location_id',
        'category_id',
        'title',
        'description',
        'photo_path',
        'status',
        'assigned_to',
        'resolved_at',
    ];

    protected $casts = [
        'resolved_at' => 'datetime',
    ];

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function location() {
        return $this->belongsTo(Location::class);
    }

    public function category() {
        return $this->belongsTo(Category::class);
    }

    public function assignedTechnician() {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function photos() {
        return $this->hasMany(ComplaintPhoto::class);
    }

    public function logs() {
        return $this->hasMany(ComplaintLog::class);
    }


}
