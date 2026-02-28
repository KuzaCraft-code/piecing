<?php
/**
 * Página Inicial - Kuzacraft Piecing
 * Layout Dinâmico com Fallback de Segurança
 */

// 1. Configuração de Slides (Fallback se não vierem da BD)
if (empty($slides)) {
    $slides = [
        [
            'title' => 'Gestão Escolar Nexora',
            'content'  => 'Plataforma educativa para o ensino secundário em Moçambique.',
            'image_path'   => '/assets/img/projects/nexora.jpg',
            'button_link'  => '/projetos/nexora',
            'tag'   => 'Educação',
            'button_text' => 'Ver Projeto'
        ],
        [
            'title' => 'E-commerce Kuzacraft',
            'content'  => 'A sua nova loja online de tecnologia na Beira.',
            'image_path'   => '/assets/img/projects/shop.jpg',
            'button_link'  => 'https://kuzacraft.shop',
            'tag'   => 'E-commerce',
            'button_text' => 'Visitar Loja'
        ]
    ];
}
include __DIR__ . '/../components/hero-slide.php';

// 2. Configuração do Hero (Prioridade CMS -> Fallback)
$hero_title = $hero['title'] ?? "Piecing: framework de inovação tecnológica da Kuzacraft";
$hero_desc  = $hero['content'] ?? "Um framework de desenvolvimento web moderno e leve, projetado para acelerar a criação de soluções digitais em Moçambique.";
$hero_link  = $hero['button_link'] ?? "/login";
$hero_text  = $hero['button_text'] ?? "Saber Mais";
$hero_img   = $hero['image_path'] ?? "/assets/img/hero-kuzacraft.jpg";
include __DIR__ . '/../components/hero.php';

// 3. Métricas (Prioridade CMS -> Fallback)
if (empty($metrics)) {
    $metrics = [
        ['value' => '+1000', 'label' => 'Parceiros'],
        ['value' => '3', 'label' => 'Localizações'],
        ['value' => '+50', 'label' => 'Projetos Concluídos']
    ];
}
include __DIR__ . '/../components/metrics.php';

// 4. Resumo / Visão Geral (Prioridade CMS -> Fallback)
$res_title = $resume['title'] ?? "Integrador Global de Tecnologia";
$res_text  = $resume['content'] ?? "A nossa visão é tornar-nos o principal parceiro tecnológico em Moçambique, integrando sistemas de gestão e infraestrutura.";
$res_img   = $resume['image_path'] ?? "/assets/img/office-beira.jpg";
$invert    = false; 
include __DIR__ . '/../components/resume.php';

// 5. Parceiros (Fallback se não houver dinâmicos)
if (empty($partners)) {
    $logos = [
        '/assets/img/logos/client1.png',
        '/assets/img/logos/client2.png',
        '/assets/img/logos/client3.png'
    ];
} else {
    $logos = array_column($partners, 'image_path');
}
include __DIR__ . '/../components/partners.php';

// 6. Newsletter e Contacto Rápido
// $db_status é passado pelo HomeController
include __DIR__ . '/../components/newsletter.php';