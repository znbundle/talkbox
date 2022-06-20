<?php

namespace ZnBundle\TalkBox\Domain\Services;

use ZnBundle\TalkBox\Domain\Entities\AnswerEntity;
use ZnBundle\TalkBox\Domain\Interfaces\Repositories\AnswerRepositoryInterface;
use ZnBundle\TalkBox\Domain\Interfaces\Services\AnswerServiceInterface;
use ZnCore\Domain\Base\BaseCrudService;
use ZnCore\Base\Libs\Query\Entities\Query;

class AnswerService extends BaseCrudService implements AnswerServiceInterface
{

    public function __construct(AnswerRepositoryInterface $repository)
    {
        $this->setRepository($repository);
    }

    public function oneByRequestTextOrCreate(string $word): AnswerEntity
    {
        $query = new Query;
        $query->where('request_text', $word);
        $collection = $this->getRepository()->all($query);
        if ($collection->count() === 0) {
            $entity = $this->createEntity();
            $entity->setRequestText($word);
            $this->getRepository()->create($entity);
        } else {
            $entity = $collection->first();
        }
        return $entity;
    }

    public function allByIds(array $answerIds)
    {
        $query = new Query;
        $query->where('id', $answerIds);
        return parent::all($query);
    }

}
