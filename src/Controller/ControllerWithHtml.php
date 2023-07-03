<?php

namespace Alura\Mvc\Controller;

// a classe não pode ser instanciada
abstract class ControllerWithHtml implements Controller
{
    private const TEMPLATE_PATH = __DIR__ . "/../../views/";

    protected function renderTemplate(string $templateName, array $context = []): string
    {
        extract($context);
        // inicializa o buffer de saída
        ob_start();
        // armazena no buffer um dado exibido
        require_once self::TEMPLATE_PATH . $templateName . ".php";
        // retorna o buffer de saída e limpa o buffer
        return ob_get_clean();
        // agora o renderTemplate não exibe nada, ele retorna o conteúdo
    }
}
