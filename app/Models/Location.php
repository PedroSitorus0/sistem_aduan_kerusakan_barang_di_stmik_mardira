<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $fillable = ['room_name'];

    public function complaints() {
        return $this->hasMany(Complaint::class);
    }

    public function getBuildingNameAttribute(): string {
        $prefix = strtoupper($this->room_name[0] ?? '');
        return match ($prefix) {
            'R' => 'Gedung 1',
            'G' => 'Gedung 2',
            default => 'Tidak Diketahui',
        };
    }
}
