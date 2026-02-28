<?php
namespace Core;

class ServiceManager {
    public static function sendEmail($to, $subject, $body) {
        // Aqui configurarias o SMTP com as chaves encriptadas que guardámos na aba Services
        $config = \Core\CMS::getSection('smtp_config'); 
        // Lógica de envio...
    }
    */
    public static function loadCMSContent() {
        $db = Database::getConnection();
        
        // Exemplo de como carregar tudo numa só consulta para performance
        $stmt = $db->query("SELECT * FROM cms_sections WHERE is_active = 1");
        $sections = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        
        $content = [];
        foreach($sections as $s) {
            $content[$s['section_slug']] = $s;
        }
        
        return $content;
    }

    public static function handleContactForm($data) {
        // 1. Encriptação ISO das chaves antes de usar
        // 2. Envio via PHPMailer...
    }
}