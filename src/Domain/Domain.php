<?php

namespace ZnBundle\TalkBox\Domain;

use ZnCore\Domain\Interfaces\DomainInterface;

class Domain implements DomainInterface
{

    public function getName()
    {
        return 'dialog';
    }


}

