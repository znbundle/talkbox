<?php

namespace ZnBundle\TalkBox\Domain\Interfaces\Services;

use ZnBundle\TalkBox\Domain\Entities\TagEntity;
use ZnCore\Domain\Collection\Interfaces\Enumerable;
use ZnCore\Domain\Query\Entities\Query;
use ZnCore\Domain\Service\Interfaces\CrudServiceInterface;

interface TagServiceInterface extends CrudServiceInterface
{

    public function allByWorlds(array $words, Query $query = null): Enumerable;

    public function findOneByWordOrCreate(string $word): TagEntity;
}
