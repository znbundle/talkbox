<?php

namespace ZnBundle\TalkBox\Domain\Interfaces\Services;

use ZnBundle\TalkBox\Domain\Entities\AnswerEntity;
use ZnCore\Domain\Interfaces\Service\CrudServiceInterface;

interface AnswerServiceInterface extends CrudServiceInterface
{

    public function oneByRequestTextOrCreate(string $word): AnswerEntity;

}

