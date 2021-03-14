<?php

namespace ZnBundle\TalkBox;

use ZnCore\Base\Libs\App\Base\BaseBundle;

class Bundle extends BaseBundle
{

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
}
