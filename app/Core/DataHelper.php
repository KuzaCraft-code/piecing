<?php

namespace Core;

trait DataHelper
{
    public function loadJsonData(string $filename)
    {
        // O dirname(__DIR__, 2) sobe de app/Core para a Raiz do Projeto
        $basePath = dirname(__DIR__, 2);
        
        // Ajuste aqui: se o arquivo estiver direto em storage, remova o '/data'
        $path = $basePath . "/storage/data/{$filename}.json";

        if (file_exists($path)) {
            $content = file_get_contents($path);
            return json_decode($content, true) ?? [];
        }

        // Isso vai aparecer no log do seu terminal se o caminho falhar
        error_log("DEBUG PIECING: Tentando abrir arquivo em: " . $path);
        return [];
    }
}