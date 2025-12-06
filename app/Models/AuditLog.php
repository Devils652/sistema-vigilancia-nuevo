<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditLog extends Model
{
    use HasFactory;

    // Indica los campos que pueden ser asignados masivamente
    protected $fillable = [
        'user_id',
        'action',
        'details',
        'auditable_type',
        'auditable_id'
    ];

    // Los campos 'details' (guardado como JSON) deben ser casteados automáticamente
    protected $casts = [
        'details' => 'array',
    ];

    // Relación Eloquent: Un log pertenece a un usuario
    public function user()
    {
        // El usuario_id puede ser nulo si la acción fue realizada por el sistema (por eso onDelete('set null') en la migración)
        return $this->belongsTo(User::class);
    }

    // Relación Polimórfica: Permite obtener el modelo afectado (Camera, User, etc.)
    public function auditable()
    {
        return $this->morphTo();
    }
}