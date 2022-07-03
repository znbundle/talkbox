<?php

namespace ZnBundle\TalkBox\Domain\Repositories\Eloquent;

use ZnCore\Domain\Collection\Libs\Collection;
use ZnBundle\TalkBox\Domain\Entities\AnswerTagEntity;
use ZnBundle\TalkBox\Domain\Interfaces\Repositories\AnswerTagRepositoryInterface;
use ZnCore\Domain\Entity\Helpers\CollectionHelper;
use ZnDatabase\Eloquent\Domain\Base\BaseEloquentCrudRepository;
use ZnCore\Domain\Entity\Helpers\EntityHelper;

class AnswerTagRepository extends BaseEloquentCrudRepository implements AnswerTagRepositoryInterface
{

    public function tableName(): string
    {
        return 'dialog_answer_tag';
    }

    public function getEntityClass(): string
    {
        return AnswerTagEntity::class;
    }

   /* public function relations()
    {
        return [

        ];
    }*/

    public function allByTagIds(array $tagIds): Collection
    {
        $array = $this->getQueryBuilder()
            ->select(['answer_id'])
            ->whereIn('tag_id', $tagIds)
            ->groupBy(['answer_id'])
            ->havingRaw('COUNT(*) = ' . count($tagIds))
            ->get();
        $entityClass = $this->getEntityClass();
        $collection = CollectionHelper::create($entityClass, $array->toArray());
        return $collection;
    }

}
