<?php

namespace ZnBundle\TalkBox\Domain\Services;

use ZnBundle\TalkBox\Domain\Interfaces\Repositories\AnswerTagRepositoryInterface;
use ZnBundle\TalkBox\Domain\Interfaces\Services\AnswerTagServiceInterface;
use ZnCore\Domain\Base\BaseCrudService;
use ZnCore\Domain\Helpers\EntityHelper;

class AnswerTagService extends BaseCrudService implements AnswerTagServiceInterface
{

    public function __construct(AnswerTagRepositoryInterface $repository)
    {
        $this->setRepository($repository);
    }

    public function answerIdsByTagIds(array $tagIds): array
    {
        $collection = $this->getRepository()->allByTagIds($tagIds);
        return EntityHelper::getColumn($collection, 'answerId');
    }
}
