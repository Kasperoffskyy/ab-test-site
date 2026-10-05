<?php

namespace App;

use Smarty\Smarty;

class View
{
    private Smarty $smarty;

    public function __construct(string $templateDir, string $cacheDir)
    {
        $this->smarty = new Smarty();
        $this->smarty->setTemplateDir($templateDir);
        $this->smarty->setCompileDir($cacheDir);
        $this->smarty->setEscapeHtml(true);
    }

    public function render(string $template, array $data = []): void
    {
        $this->smarty->assign($data);
        $this->smarty->display($template);
    }

    public function notFound(): void
    {
        http_response_code(404);
        $this->render('404.tpl');
    }
}
