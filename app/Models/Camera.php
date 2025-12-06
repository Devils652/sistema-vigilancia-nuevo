<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Auditable; // <--- Importar

class Camera extends Model
{
    use HasFactory, Auditable; // <--- Activar

    protected $fillable = [
        'name',
        'ip',
        'location',
        'status',
        'group',
        'user_id'
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}