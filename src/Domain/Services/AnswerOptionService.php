<?php

namespace ZnBundle\TalkBox\Domain\Services;

use ZnBundle\TalkBox\Domain\Interfaces\Repositories\AnswerOptionRepositoryInterface;
use ZnBundle\TalkBox\Domain\Interfaces\Services\AnswerOptionServiceInterface;
use ZnCore\Domain\Service\Base\BaseCrudService;
use ZnCore\Domain\Query\Entities\Query;

class AnswerOptionService extends BaseCrudService implements AnswerOptionServiceInterface
{

    public function __construct(AnswerOptionRepositoryInterface $repository)
    {
        $this->setRepository($repository);
    }

    public function allByAnswerIds(array $answerIds)
    {
        $query = new Query;
        $query->where('answer_id', $answerIds);
        $query->orderBy([
            'sort' => SORT_ASC,
        ]);
        return parent::findAll($query);
    }
}
