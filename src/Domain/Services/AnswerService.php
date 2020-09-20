<?php

namespace ZnBundle\TalkBox\Domain\Services;

use ZnBundle\TalkBox\Domain\Entities\AnswerEntity;
use ZnBundle\TalkBox\Domain\Interfaces\Repositories\AnswerRepositoryInterface;
use ZnBundle\TalkBox\Domain\Interfaces\Services\AnswerServiceInterface;
use ZnCore\Domain\Base\BaseCrudService;
use ZnCore\Domain\Libs\Query;

class AnswerService extends BaseCrudService implements AnswerServiceInterface
{

    public function __construct(AnswerRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function oneByRequestTextOrCreate(string $word): AnswerEntity
    {
        $query = new Query;
        $query->where('request_text', $word);
        $collection = $this->repository->all($query);
        if ($collection->count() === 0) {
            $entity = $this->createEntity();
            $entity->setRequestText($word);
            $this->repository->create($entity);
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
