<?php
namespace Controllers;

use Core\Controller;
use Core\Database;

class HomeController extends Controller {
    
    public function index() {
        $db = Database::getConnection();
        
        // 1. CARREGAMENTO EM MASSA (Estratégia de Performance)
        // Buscamos todas as secções ativas de uma só vez
        $stmt = $db->query("SELECT section_slug, title, content, image_path, button_text, button_link FROM cms_sections WHERE is_active = 1");
        $cmsData = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        // 2. MAPEAMENTO DE DADOS
        // Transformamos o array plano num array associativo indexado pelo 'slug'
        $sections = [];
        foreach ($cmsData as $row) {
            $sections[$row['section_slug']] = $row;
        }

        // 3. CARREGAMENTO DE DINÂMICOS (Slides e Parceiros)
        // Estes geralmente vêm de tabelas separadas ou JSON
        $slides = $db->query("SELECT * FROM catalog WHERE type = 'subscription' AND status = 'active' LIMIT 5")->fetchAll();
        
        // 4. VERIFICAÇÃO DE STATUS PARA NEWSLETTER
        $dbOnline = true; // Se chegou aqui, a BD está ativa

        // 5. RENDERIZAÇÃO
        return $this->view('home/index', [
            'title'      => 'Kuzacraft | Agência de TI na Beira',
            'hero'       => $sections['hero'] ?? null,
            'resume'     => $sections['resume'] ?? null,
            'metrics'    => json_decode($sections['metrics']['content'] ?? '[]', true),
            'slides'     => $slides,
            'db_status'  => $dbOnline
        ]);
    }
}