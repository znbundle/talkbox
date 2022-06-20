<?php

namespace ZnBundle\TalkBox\Domain\Interfaces\Services;

use ZnBundle\TalkBox\Domain\Entities\AnswerEntity;
use ZnCore\Base\Libs\Service\Interfaces\CrudServiceInterface;

interface AnswerServiceInterface extends CrudServiceInterface
{

    public function oneByRequestTextOrCreate(string $word): AnswerEntity;

}

