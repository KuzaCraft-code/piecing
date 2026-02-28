<?php
namespace Core;

class Router {
    protected $routes = [];

    public function get($uri, $callback) {
        $this->addRoute('GET', $uri, $callback);
    }

    public function post($uri, $callback) {
        $this->addRoute('POST', $uri, $callback);
    }

    protected function addRoute($method, $uri, $callback) {
        // Verifica se é uma rota dinâmica (tem chaves {})
        $isDynamic = strpos($uri, '{') !== false;
        
        if ($isDynamic) {
            $pattern = preg_replace('/\{([a-zA-Z0-9_]+)\}/', '(?P<\1>[a-zA-Z0-9_-]+)', $uri);
            $pattern = "#^" . $pattern . "$#";
        } else {
            $pattern = $uri; // Mantém a string simples para alta performance
        }
        
        $this->routes[] = [
            'method'     => $method,
            'pattern'    => $pattern,
            'is_dynamic' => $isDynamic,
            'callback'   => $callback
        ];
    }

    public function dispatch() {
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $method = $_SERVER['REQUEST_METHOD'];

        foreach ($this->routes as $route) {
            // Ignora imediatamente se o método não bater
            if ($route['method'] !== $method) continue;

            // Fast-Track: Comparação estática ultra-rápida (para /, /about, /login)
            if (!$route['is_dynamic'] && $route['pattern'] === $uri) {
                return $this->executeCallback($route['callback'], []);
            }
            
            // Fallback: Avaliação Regex (apenas para rotas como /servico/cctv)
            if ($route['is_dynamic'] && preg_match($route['pattern'], $uri, $matches)) {
                $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);
                return $this->executeCallback($route['callback'], $params);
            }
        }

        http_response_code(404);
        echo "404 - Piecing:  não encontrado.";
    }

    // Helper para manter o código DRY
    private function executeCallback($callback, $params) {
        if (is_array($callback)) {
            $controller = new $callback[0];
            return call_user_func_array([$controller, $callback[1]], $params);
        }
        return call_user_func_array($callback, $params);
    }
}