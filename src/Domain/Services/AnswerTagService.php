<?php

namespace ZnBundle\TalkBox\Domain\Services;

use ZnBundle\TalkBox\Domain\Interfaces\Repositories\AnswerTagRepositoryInterface;
use ZnBundle\TalkBox\Domain\Interfaces\Services\AnswerTagServiceInterface;
use ZnCore\Base\Libs\Entity\Helpers\CollectionHelper;
use ZnCore\Base\Libs\Service\Base\BaseCrudService;
use ZnCore\Base\Libs\Entity\Helpers\EntityHelper;

class AnswerTagService extends BaseCrudService implements AnswerTagServiceInterface
{

    public function __construct(AnswerTagRepositoryInterface $repository)
    {
        $this->setRepository($repository);
    }

    public function answerIdsByTagIds(array $tagIds): array
    {
        $collection = $this->getRepository()->allByTagIds($tagIds);
        return CollectionHelper::getColumn($collection, 'answerId');
    }
}
