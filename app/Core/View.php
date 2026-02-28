<?php
namespace Core;

class View {
    public static function render($view, $data = [], $layout = 'main') {
        extract($data);
        $basePath = __DIR__ . "/../Views";

        // 1. Liga o motor de captura (Guarda o HTML na RAM)
        ob_start();
        require $basePath . "/" . $view . ".php";
        $content = ob_get_clean(); // O HTML da página específica está agora na variável $content

        // 2. Carrega o Layout mestre e injeta o $content lá dentro
        require $basePath . "/layouts/" . $layout . ".php";
    }
}