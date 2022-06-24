<?php

namespace ZnBundle\TalkBox;

use ZnCore\Base\Bundle\Base\BaseBundle;

class Bundle extends BaseBundle
{
    
    public function console(): array
    {
        return [
            'ZnBundle\TalkBox\Commands',
        ];
    }
    
    public function migration(): array
    {
        return [
            '/vendor/znbundle/talkbox/src/Domain/Migrations',
        ];
    }

    public function container(): array
    {
        return [
            __DIR__ . '/Domain/config/container.php',
        ];
    }

    public function telegramRoutes(): array
    {
        return [
            __DIR__ . '/Telegram/config/routes.php',
        ];
    }
}
