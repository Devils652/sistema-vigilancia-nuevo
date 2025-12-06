<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Auditable;

class Camera extends Model
{
    use HasFactory, Auditable;

    protected $fillable = [
        'name',
        'ip',
        'location',
        'status',
        'camera_group_id', // <--- CAMBIO: Ahora usamos el ID
        'user_id'
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Nueva relación: Una cámara pertenece a un Grupo
    public function cameraGroup()
    {
        return $this->belongsTo(CameraGroup::class, 'camera_group_id');
    }
}