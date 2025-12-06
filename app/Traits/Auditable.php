<?php

namespace App\Traits;

use App\Models\AuditLog;
use Illuminate\Support\Facades\Auth;

trait Auditable
{
    /**
     * Define los eventos de Eloquent a auditar.
     */
    public static function bootAuditable()
    {
        // Al crear un nuevo registro
        static::created(function ($model) {
            self::logAction('created', $model);
        });

        // Al actualizar un registro existente
        static::updated(function ($model) {
            // Registra los cambios originales y los nuevos
            self::logAction('updated', $model, [
                'original' => $model->getOriginal(),
                'new' => $model->getChanges()
            ]);
        });

        // Al eliminar un registro
        static::deleted(function ($model) {
            self::logAction('deleted', $model);
        });
    }

    /**
     * Registra una acción en la tabla audit_logs.
     *
     * @param string $action
     * @param \Illuminate\Database\Eloquent\Model $model
     * @param array $details
     */
    protected static function logAction(string $action, $model, array $details = [])
    {
        // Solo auditar si hay un usuario autenticado realizando la acción
        if (!Auth::check()) {
            return;
        }

        AuditLog::create([
            'user_id' => Auth::id(),
            'action' => $action,
            'details' => json_encode($details),
            
            'auditable_type' => get_class($model),
            'auditable_id' => $model->id,
        ]);
    }
}
