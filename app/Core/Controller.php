<?php
namespace Core;

class Controller
{
    /**
     * Renderiza a View usando o novo motor de Layouts do Piecing
     */
    protected function view(string $view, array $data = [], string $layout = 'main')
    {
        // Delega o trabalho para a tua nova classe View
        View::render($view, $data, $layout);
    }
}