<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Traits\Auditable; 

class User extends Authenticatable
{
    use HasFactory, Notifiable, Auditable; 
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'status',
        'supervisor_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'status' => 'boolean',
    ];

    //Implementacion de Gates (Compuertas)

    // Relación con Rol (Tu sistema manual)
    public function role()
    {
        return $this->belongsTo(Role::class);
    }
    
    // Relación con Cámaras
    public function cameras()
    {
        return $this->hasMany(Camera::class);
    }

    // Relación: "Yo tengo un Supervisor"
    public function supervisor()
    {
        return $this->belongsTo(User::class, 'supervisor_id');
    }

    // Relación: "Yo soy supervisor de estos usuarios"
    public function subordinates()
    {
        return $this->hasMany(User::class, 'supervisor_id');
    }
}