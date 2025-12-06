<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CameraGroup extends Model
{
    protected $fillable = ['name'];

    // Relación inversa: Un grupo tiene muchas cámaras
    public function cameras()
    {
        return $this->hasMany(Camera::class, 'camera_group_id');
    }
}