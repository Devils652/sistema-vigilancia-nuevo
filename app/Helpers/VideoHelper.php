<?php

namespace App\Helpers;

class VideoHelper
{
    /**
     * Analiza la IP/URL y devuelve una URL sanitizada y segura.
     */
    public static function parseUrl(string $url): array
    {
        // 1. Limpieza básica (quitar espacios y etiquetas HTML por si acaso)
        $url = strip_tags(trim($url)); 
        
        $isYoutube = false;
        $streamUrl = '';

        // 2. Detección segura de YouTube
        if (str_contains($url, 'youtube.com') || str_contains($url, 'youtu.be')) {
            $isYoutube = true;
            // Solo extraemos caracteres alfanuméricos para el ID (evita inyección en la URL)
            preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $url, $match);
            $videoId = $match[1] ?? null;
            
            // Si no hay ID válido, no mostramos nada
            if ($videoId) {
                $streamUrl = "https://www.youtube.com/embed/{$videoId}?autoplay=1&mute=1&controls=0&disablekb=1&modestbranding=1&rel=0&loop=1&playlist={$videoId}";
            }
        } 
        // 3. Validación estricta de protocolo HTTP/HTTPS
        elseif (str_starts_with($url, 'http://') || str_starts_with($url, 'https://')) {
            $streamUrl = $url;
        } 
        // 4. Si es IP + Puerto (ej: 192.168.1.50:8080)
        elseif (preg_match('/^\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}:\d+$/', $url)) {
            $streamUrl = "http://{$url}/video";
        } 
        // 5. Si es solo IP (ej: 192.168.1.50)
        elseif (filter_var($url, FILTER_VALIDATE_IP)) {
            $streamUrl = "http://{$url}:81/stream";
        }
        // 6. Si no coincide con nada seguro, devolvemos vacío para no romper el frontend
        else {
            $streamUrl = ''; 
        }

        return [
            'isYoutube' => $isYoutube,
            'streamUrl' => $streamUrl,
        ];
    }
}