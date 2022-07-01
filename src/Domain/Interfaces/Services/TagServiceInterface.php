<?php

namespace ZnBundle\TalkBox\Domain\Interfaces\Services;

use ZnBundle\TalkBox\Domain\Entities\TagEntity;
use Illuminate\Support\Collection;
use ZnCore\Domain\Service\Interfaces\CrudServiceInterface;
use ZnCore\Domain\Query\Entities\Query;

interface TagServiceInterface extends CrudServiceInterface
{

    public function allByWorlds(array $words, Query $query = null): Collection;
    public function findOneByWordOrCreate(string $word): TagEntity;
}
